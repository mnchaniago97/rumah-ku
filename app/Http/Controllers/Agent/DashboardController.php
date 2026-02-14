<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $agentProfile = Auth::user()?->fresh();

        $baseSubsidiQuery = Property::query()
            ->where('user_id', Auth::id())
            ->whereHas('listingCategories', fn ($q) => $q->where('slug', 'rumah-subsidi'));

        $rumahSubsidiCount = (clone $baseSubsidiQuery)->count();
        $rumahSubsidiLatest = (clone $baseSubsidiQuery)
            ->with(['images'])
            ->latest()
            ->take(4)
            ->get();

        return view('agent.pages.dashboard.dashboard', [
            'title' => 'Dashboard',
            'rumahSubsidiCount' => $rumahSubsidiCount,
            'rumahSubsidiLatest' => $rumahSubsidiLatest,
            'agentProfile' => $agentProfile,
        ]);
    }
}


