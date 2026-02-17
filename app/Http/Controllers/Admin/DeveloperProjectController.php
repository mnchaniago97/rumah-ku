<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeveloperProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::with(['user', 'properties'])
            ->withCount('properties')
            ->latest();

        // Filter by developer
        if ($request->filled('developer_id')) {
            $query->where('user_id', $request->developer_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by published
        if ($request->filled('is_published')) {
            $query->where('is_published', $request->is_published === 'yes');
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%");
            });
        }

        $projects = $query->paginate(20)->withQueryString();

        // Get all developers for filter dropdown
        $developers = User::where('agent_type', AgentApplication::TYPE_DEVELOPER)
            ->whereNotNull('agent_verified_at')
            ->orderBy('company_name')
            ->get();

        return view('admin.pages.developer-projects.index', [
            'title' => 'Manajemen Proyek Developer',
            'projects' => $projects,
            'developers' => $developers,
        ]);
    }

    public function show(Project $developer_project): View
    {
        $developer_project->load(['user', 'properties.images', 'properties.category']);

        return view('admin.pages.developer-projects.show', [
            'title' => $developer_project->name,
            'project' => $developer_project,
        ]);
    }

    public function edit(Project $developer_project): View
    {
        $developer_project->load('user');

        return view('admin.pages.developer-projects.edit', [
            'title' => 'Edit Proyek',
            'project' => $developer_project,
        ]);
    }

    public function update(Request $request, Project $developer_project): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:projects,slug,' . $developer_project->id],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'price_start' => ['nullable', 'numeric', 'min:0'],
            'price_end' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'total_units' => ['nullable', 'integer', 'min:0'],
            'available_units' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'string', 'in:active,completed,on-hold,cancelled'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        $developer_project->update($data);

        return redirect()
            ->route('admin.developer-projects.show', $developer_project)
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $developer_project): RedirectResponse
    {
        $developer_project->delete();

        return redirect()
            ->route('admin.developer-projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }

    public function togglePublish(Project $developer_project): RedirectResponse
    {
        $developer_project->update([
            'is_published' => !$developer_project->is_published,
        ]);

        $status = $developer_project->is_published ? 'dipublikasikan' : 'disembunyikan';

        return back()->with('success', "Proyek berhasil {$status}.");
    }
}
