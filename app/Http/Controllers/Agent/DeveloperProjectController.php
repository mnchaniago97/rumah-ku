<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DeveloperProjectController extends Controller
{
    /**
     * Check if user is a developer.
     */
    private function checkDeveloper(): void
    {
        $user = Auth::user();
        if ($user?->agent_type !== AgentApplication::TYPE_DEVELOPER) {
            abort(403, 'Only developers can access this page.');
        }
    }

    public function index(): View
    {
        $this->checkDeveloper();
        
        $user = Auth::user();
        $projects = Project::where('user_id', $user->id)
            ->with('properties')
            ->latest()
            ->get();

        // Check max projects limit from subscription plan
        $maxProjects = $this->getMaxProjects();
        $activeProjects = $projects->where('status', 'active')->count();

        return view('agent.pages.developer.projects.index', [
            'title' => 'Proyek Developer',
            'projects' => $projects,
            'maxProjects' => $maxProjects,
            'activeProjects' => $activeProjects,
            'canCreateProject' => $maxProjects === -1 || $activeProjects < $maxProjects,
        ]);
    }

    public function create(): View
    {
        $this->checkDeveloper();
        
        $user = Auth::user();
        $maxProjects = $this->getMaxProjects();
        $activeProjects = Project::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        if ($maxProjects !== -1 && $activeProjects >= $maxProjects) {
            return redirect()
                ->route('agent.developer-projects.index')
                ->with('error', 'Anda telah mencapai batas maksimal proyek aktif untuk paket Anda.');
        }

        return view('agent.pages.developer.projects.create', [
            'title' => 'Tambah Proyek',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkDeveloper();
        
        $user = Auth::user();
        $maxProjects = $this->getMaxProjects();
        $activeProjects = Project::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        if ($maxProjects !== -1 && $activeProjects >= $maxProjects) {
            return redirect()
                ->route('agent.developer-projects.index')
                ->with('error', 'Anda telah mencapai batas maksimal proyek aktif untuk paket Anda.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:projects,slug'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'price_start' => ['nullable', 'numeric', 'min:0'],
            'price_end' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'brochure' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'total_units' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $data['user_id'] = $user->id;
        $data['status'] = 'active';
        $data['is_published'] = false;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('project-logos', 'uploads');
            $data['logo'] = '/storage/' . $path;
        }

        // Handle brochure upload
        if ($request->hasFile('brochure')) {
            $path = $request->file('brochure')->store('project-brochures', 'uploads');
            $data['brochure'] = '/storage/' . $path;
        }

        $project = Project::create($data);

        return redirect()
            ->route('agent.developer-projects.show', $project)
            ->with('success', 'Proyek berhasil dibuat.');
    }

    public function show(Project $developer_project): View
    {
        $this->checkDeveloper();
        
        $developer_project->load(['properties.images', 'properties.category']);

        return view('agent.pages.developer.projects.show', [
            'title' => $developer_project->name,
            'project' => $developer_project,
        ]);
    }

    public function edit(Project $developer_project): View
    {
        $this->checkDeveloper();
        
        return view('agent.pages.developer.projects.edit', [
            'title' => 'Edit Proyek',
            'project' => $developer_project,
        ]);
    }

    public function update(Request $request, Project $developer_project): RedirectResponse
    {
        $this->checkDeveloper();
        
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:projects,slug,' . $developer_project->id],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'price_start' => ['nullable', 'numeric', 'min:0'],
            'price_end' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'brochure' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'total_units' => ['nullable', 'integer', 'min:0'],
            'available_units' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'string', 'in:active,completed,on-hold,cancelled'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($developer_project->logo) {
                $oldPath = str_replace('/storage/', '', $developer_project->logo);
                Storage::disk('uploads')->delete($oldPath);
            }
            $path = $request->file('logo')->store('project-logos', 'uploads');
            $data['logo'] = '/storage/' . $path;
        }

        // Handle brochure upload
        if ($request->hasFile('brochure')) {
            if ($developer_project->brochure) {
                $oldPath = str_replace('/storage/', '', $developer_project->brochure);
                Storage::disk('uploads')->delete($oldPath);
            }
            $path = $request->file('brochure')->store('project-brochures', 'uploads');
            $data['brochure'] = '/storage/' . $path;
        }

        $data['is_published'] = $request->boolean('is_published');

        $developer_project->update($data);

        return redirect()
            ->route('agent.developer-projects.show', $developer_project)
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $developer_project): RedirectResponse
    {
        $this->checkDeveloper();
        
        // Delete associated files
        if ($developer_project->logo) {
            $oldPath = str_replace('/storage/', '', $developer_project->logo);
            Storage::disk('uploads')->delete($oldPath);
        }
        if ($developer_project->brochure) {
            $oldPath = str_replace('/storage/', '', $developer_project->brochure);
            Storage::disk('uploads')->delete($oldPath);
        }

        $developer_project->delete();

        return redirect()
            ->route('agent.developer-projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }

    private function getMaxProjects(): int
    {
        $user = Auth::user();
        $access = $user?->agentAccess();

        if ($access === null) {
            return 1; // Default to 1 project
        }

        return $access['max_projects'] ?? 1;
    }
}
