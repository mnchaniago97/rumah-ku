<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function index(): View
    {
        $agents = Agent::latest()->get();

        return view('agent.pages.agent.index', [
            'title' => 'Agents',
            'agents' => $agents,
        ]);
    }

    public function create(): View
    {
        return view('agent.pages.agent.create', [
            'title' => 'Create Agent',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        Agent::create($data);

        return redirect()
            ->route('agent.agents.index')
            ->with('success', 'Agent created.');
    }

    public function show(Agent $agent): View
    {
        return view('agent.pages.agent.show', [
            'title' => 'Agent Detail',
            'agent' => $agent,
        ]);
    }

    public function edit(Agent $agent): View
    {
        return view('agent.pages.agent.edit', [
            'title' => 'Edit Agent',
            'agent' => $agent,
        ]);
    }

    public function update(Request $request, Agent $agent): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $agent->update($data);

        return redirect()
            ->route('agent.agents.index')
            ->with('success', 'Agent updated.');
    }

    public function destroy(Agent $agent): RedirectResponse
    {
        $agent->delete();

        return redirect()
            ->route('agent.agents.index')
            ->with('success', 'Agent deleted.');
    }
}


