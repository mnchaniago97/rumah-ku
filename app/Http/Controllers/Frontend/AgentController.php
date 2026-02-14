<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $city = trim((string) $request->query('city', ''));

        $agentsQuery = User::query()
            ->where('role', 'agent')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', '%' . $q . '%')
                        ->orWhere('email', 'like', '%' . $q . '%')
                        ->orWhere('phone', 'like', '%' . $q . '%');
                });
            })
            ->when($city !== '', function ($query) use ($city) {
                $query->whereHas('properties', function ($qq) use ($city) {
                    $qq->where('is_published', true)
                        ->where('is_approved', true)
                        ->where('city', $city);
                });
            })
            ->withCount([
                'properties as published_properties_count' => function ($query) {
                    $query->where('is_published', true)->where('is_approved', true);
                },
            ])
            ->latest();

        $agents = (clone $agentsQuery)
            ->paginate(12)
            ->withQueryString();

        $topAgents = User::query()
            ->where('role', 'agent')
            ->withCount([
                'properties as published_properties_count' => function ($query) {
                    $query->where('is_published', true)->where('is_approved', true);
                },
            ])
            ->orderByDesc('published_properties_count')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        $cityOptions = Property::query()
            ->where('is_published', true)
            ->where('is_approved', true)
            ->whereHas('user', fn ($q) => $q->where('role', 'agent'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return view('frontend.pages.agents', [
            'title' => 'Agents',
            'agents' => $agents,
            'topAgents' => $topAgents,
            'cityOptions' => $cityOptions,
            'filters' => [
                'q' => $q,
                'city' => $city,
            ],
        ]);
    }

    public function show(User $agent): View
    {
        if ($agent->role !== 'agent') {
            abort(404);
        }

        $agent->loadCount([
            'properties as published_properties_count' => function ($query) {
                $query->where('is_published', true)->where('is_approved', true);
            },
        ]);

        $properties = Property::with(['images', 'listingCategories'])
            ->where('user_id', $agent->getKey())
            ->where('is_published', true)
            ->where('is_approved', true)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.pages.agent-show', [
            'title' => $agent->name,
            'agent' => $agent,
            'properties' => $properties,
        ]);
    }
}

