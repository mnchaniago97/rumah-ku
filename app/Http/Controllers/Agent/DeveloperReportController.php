<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use App\Models\Property;
use App\Models\Project;
use App\Models\PropertyInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeveloperReportController extends Controller
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
     * Display the reports dashboard with analytics.
     */
    public function index(Request $request)
    {
        $this->checkDeveloper();
        
        $user = Auth::user();

        // Summary Statistics
        $totalProperties = Property::where('user_id', $user->id)->count();
        $publishedProperties = Property::where('user_id', $user->id)->where('is_published', true)->count();
        
        $totalProjects = Project::where('user_id', $user->id)->count();
        $activeProjects = Project::where('user_id', $user->id)->where('status', 'active')->count();

        // Views statistics
        $totalViews = Property::where('user_id', $user->id)->sum('views');
        $viewsThisMonth = Property::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('views');

        // Inquiries statistics
        $totalInquiries = PropertyInquiry::whereHas('property', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        $inquiriesThisMonth = PropertyInquiry::whereHas('property', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->whereMonth('created_at', now()->month)
          ->whereYear('created_at', now()->year)
          ->count();

        // Views Chart Data (Last 6 months)
        $viewsChart = $this->getViewsChartData($user->id);

        // Inquiries Chart Data (Last 6 months)
        $inquiriesChart = $this->getInquiriesChartData($user->id);

        // Properties by Status
        $propertiesByStatus = [
            'Aktif' => Property::where('user_id', $user->id)->where('is_published', true)->count(),
            'Draft' => Property::where('user_id', $user->id)->where('is_published', false)->count(),
            'Expired' => Property::where('user_id', $user->id)
                ->where('listing_expires_at', '<', now())
                ->count(),
        ];

        // Properties by Category
        $propertiesByCategory = Property::where('user_id', $user->id)
            ->join('categories', 'properties.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->pluck('total', 'name')
            ->toArray();

        if (empty($propertiesByCategory)) {
            $propertiesByCategory = ['Tidak ada data' => 0];
        }

        // Top Projects by Views
        $topProjects = Project::where('user_id', $user->id)
            ->withCount(['properties as views_count' => function ($q) {
                $q->select(DB::raw('coalesce(sum(views), 0)'));
            }])
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();

        // Recent Properties
        $recentProperties = Property::where('user_id', $user->id)
            ->with('category')
            ->latest()
            ->limit(5)
            ->get();

        // Recent Inquiries
        $recentInquiries = PropertyInquiry::whereHas('property', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->with('property')
        ->latest()
        ->limit(5)
        ->get();

        return view('agent.pages.developer.reports.index', compact(
            'totalProperties',
            'publishedProperties',
            'totalProjects',
            'activeProjects',
            'totalViews',
            'viewsThisMonth',
            'totalInquiries',
            'inquiriesThisMonth',
            'viewsChart',
            'inquiriesChart',
            'propertiesByStatus',
            'propertiesByCategory',
            'topProjects',
            'recentProperties',
            'recentInquiries'
        ));
    }

    /**
     * Get views chart data for the last 6 months.
     */
    private function getViewsChartData(int $userId): array
    {
        $labels = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            $views = Property::where('user_id', $userId)
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('views');
            
            $data[] = (int) $views;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Get inquiries chart data for the last 6 months.
     */
    private function getInquiriesChartData(int $userId): array
    {
        $labels = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            $count = PropertyInquiry::whereHas('property', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->count();
            
            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
