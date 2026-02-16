<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAgentTypeRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function index(): View
    {
        $agents = User::where('role', 'agent')->with('agentPlan')->latest()->get();

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

    public function updateType(UpdateAgentTypeRequest $request, User $agent): RedirectResponse
    {
        $this->ensureAgent($agent);

        $data = $request->validated();

        $agent->update([
            'agent_type' => $data['agent_type'] ?? null,
            'is_active' => array_key_exists('is_active', $data) ? (bool)$data['is_active'] : $agent->is_active,
        ]);

        return redirect()
            ->route('admin.agents.show', $agent)
            ->with('success', 'Tipe agent berhasil diperbarui.');
    }

    public function verify(User $agent): RedirectResponse
    {
        $this->ensureAgent($agent);

        $agent->update([
            'agent_verified_at' => $agent->agent_verified_at ?? now(),
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.agents.show', $agent)
            ->with('success', 'Agent berhasil diverifikasi.');
    }

    public function unverify(User $agent): RedirectResponse
    {
        $this->ensureAgent($agent);

        $agent->update([
            'agent_verified_at' => null,
        ]);

        return redirect()
            ->route('admin.agents.show', $agent)
            ->with('success', 'Verifikasi agent dibatalkan.');
    }

    private function ensureAgent(User $agent): void
    {
        if ($agent->role !== 'agent') {
            abort(404);
        }
    }
}
