<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function index(): View
    {
        $agents = User::where('role', 'agent')->latest()->get();

        return view('admin.pages.agent.index', [
            'title' => 'Agents',
            'agents' => $agents,
        ]);
    }

    public function show(User $agent): View
    {
        $this->ensureAgent($agent);

        return view('admin.pages.agent.show', [
            'title' => 'Agent Detail',
            'agent' => $agent,
        ]);
    }

    public function approve(User $agent): RedirectResponse
    {
        $this->ensureAgent($agent);

        $agent->update(['is_active' => true]);

        return redirect()
            ->route('admin.agents.index')
            ->with('success', 'Agent approved.');
    }

    public function reject(User $agent): RedirectResponse
    {
        $this->ensureAgent($agent);

        $agent->delete();

        return redirect()
            ->route('admin.agents.index')
            ->with('success', 'Agent rejected.');
    }

    private function ensureAgent(User $agent): void
    {
        if ($agent->role !== 'agent') {
            abort(404);
        }
    }
}
