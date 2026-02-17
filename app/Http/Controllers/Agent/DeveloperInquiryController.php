<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use App\Models\DeveloperInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperInquiryController extends Controller
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

    /**
     * Display a listing of inquiries.
     */
    public function index(Request $request)
    {
        $this->checkDeveloper();
        
        $user = Auth::user();
        
        $query = DeveloperInquiry::where('developer_id', $user->id)
            ->with('project');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by project
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->latest()
            ->paginate(15)
            ->appends($request->query());

        // Get status counts
        $statusCounts = [
            'all' => DeveloperInquiry::where('developer_id', $user->id)->count(),
            'new' => DeveloperInquiry::where('developer_id', $user->id)->where('status', 'new')->count(),
            'contacted' => DeveloperInquiry::where('developer_id', $user->id)->where('status', 'contacted')->count(),
            'qualified' => DeveloperInquiry::where('developer_id', $user->id)->where('status', 'qualified')->count(),
            'closed' => DeveloperInquiry::where('developer_id', $user->id)->where('status', 'closed')->count(),
            'rejected' => DeveloperInquiry::where('developer_id', $user->id)->where('status', 'rejected')->count(),
        ];

        return view('agent.pages.developer.inquiries.index', compact('inquiries', 'statusCounts'));
    }

    /**
     * Display a specific inquiry.
     */
    public function show($id)
    {
        $this->checkDeveloper();
        
        $user = Auth::user();
        
        $inquiry = DeveloperInquiry::where('developer_id', $user->id)
            ->with('project')
            ->findOrFail($id);

        return view('agent.pages.developer.inquiries.show', compact('inquiry'));
    }

    /**
     * Update inquiry status.
     */
    public function updateStatus(Request $request, $id)
    {
        $this->checkDeveloper();
        
        $user = Auth::user();
        
        $request->validate([
            'status' => 'required|in:new,contacted,qualified,closed,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        $inquiry = DeveloperInquiry::where('developer_id', $user->id)
            ->findOrFail($id);

        $inquiry->status = $request->status;
        
        if ($request->filled('notes')) {
            $inquiry->notes = $request->notes;
        }

        if ($request->status === 'contacted' && !$inquiry->contacted_at) {
            $inquiry->contacted_at = now();
        }

        $inquiry->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status inquiry berhasil diperbarui.',
                'data' => $inquiry,
            ]);
        }

        return redirect()->back()->with('success', 'Status inquiry berhasil diperbarui.');
    }

    /**
     * Remove an inquiry.
     */
    public function destroy($id)
    {
        $this->checkDeveloper();
        
        $user = Auth::user();
        
        $inquiry = DeveloperInquiry::where('developer_id', $user->id)
            ->findOrFail($id);

        $inquiry->delete();

        return redirect()->route('agent.developer-inquiries.index')
            ->with('success', 'Inquiry berhasil dihapus.');
    }
}