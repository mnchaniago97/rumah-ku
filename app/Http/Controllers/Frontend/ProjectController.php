<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DeveloperInquiry;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(): View
    {
        $projects = Project::with(['user', 'properties'])
            ->where('status', 'active')
            ->where('is_published', true)
            ->whereHas('user', function ($q) {
                $q->where('agent_type', 'developer');
            })
            ->withCount('properties')
            ->latest()
            ->paginate(12);

        return view('frontend.pages.projects.index', [
            'title' => 'Proyek Developer - Rumah IO',
            'projects' => $projects,
        ]);
    }

    /**
     * Display a specific project.
     */
    public function show(string $slug): View
    {
        $project = Project::with(['user', 'properties.images', 'properties.category'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->where('is_published', true)
            ->whereHas('user', function ($q) {
                $q->where('agent_type', 'developer');
            })
            ->firstOrFail();

        // Get similar projects from the same developer
        $similarProjects = Project::with(['user'])
            ->where('user_id', $project->user_id)
            ->where('id', '!=', $project->id)
            ->where('status', 'active')
            ->where('is_published', true)
            ->withCount('properties')
            ->take(3)
            ->get();

        return view('frontend.pages.projects.show', [
            'title' => $project->name . ' - Rumah IO',
            'project' => $project,
            'similarProjects' => $similarProjects,
        ]);
    }

    /**
     * Store a new inquiry for a project.
     */
    public function inquiry(Request $request, string $slug)
    {
        $project = Project::with(['user'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->where('is_published', true)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
            'property_type_interest' => 'nullable|string|max:100',
            'budget_min' => 'nullable|numeric|min:0',
            'budget_max' => 'nullable|numeric|min:0|gte:budget_min',
            'financing_type' => 'nullable|string|in:cash,kpr,installment',
            'wants_site_visit' => 'nullable|boolean',
            'preferred_visit_date' => 'nullable|date|after:today',
        ]);

        // Create the inquiry
        $inquiry = DeveloperInquiry::create([
            'developer_id' => $project->user_id,
            'project_id' => $project->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'property_type_interest' => $validated['property_type_interest'] ?? null,
            'budget_min' => $validated['budget_min'] ?? null,
            'budget_max' => $validated['budget_max'] ?? null,
            'financing_type' => $validated['financing_type'] ?? 'cash',
            'wants_site_visit' => $validated['wants_site_visit'] ?? false,
            'preferred_visit_date' => $validated['preferred_visit_date'] ?? null,
            'status' => 'new',
            'page_url' => $request->fullUrl(),
            'referrer' => $request->header('referer'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Check if request is AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Inquiry Anda telah berhasil dikirim. Developer akan segera menghubungi Anda.',
                'data' => $inquiry,
            ]);
        }

        return redirect()->back()->with('success', 'Inquiry Anda telah berhasil dikirim. Developer akan segera menghubungi Anda.');
    }
}