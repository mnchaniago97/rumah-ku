<?php

namespace App\Http\Middleware;

use App\Models\AgentApplication;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAgentFeature
{
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (($user->role ?? null) !== 'agent') {
            abort(403);
        }

        $default = match ($feature) {
            'rumah_subsidi' => ($user->agent_type ?? null) === AgentApplication::TYPE_PROPERTY_AGENT,
            default => true,
        };

        if (!$user->canAgentFeature($feature, $default)) {
            abort(403);
        }

        return $next($request);
    }
}

