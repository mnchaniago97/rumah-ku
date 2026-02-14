<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $agentProfile = Auth::user()?->fresh();
        $agentId = Auth::id();

        $year = now()->year;
        $month = now()->month;

        $agentPropertiesQuery = Property::query()->where('user_id', $agentId);

        $propertiesTotal = (clone $agentPropertiesQuery)->count();
        $propertiesPendingApproval = (clone $agentPropertiesQuery)->where('is_approved', false)->count();

        $propertiesPublishedTotal = (clone $agentPropertiesQuery)
            ->where('is_published', true)
            ->where('is_approved', true)
            ->count();

        $propertiesDraftTotal = (clone $agentPropertiesQuery)
            ->where('is_published', false)
            ->count();

        $createdThisMonth = (clone $agentPropertiesQuery)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $createdPrevMonth = (clone $agentPropertiesQuery)
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        $pendingCreatedThisMonth = (clone $agentPropertiesQuery)
            ->where('is_approved', false)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $pendingCreatedPrevMonth = (clone $agentPropertiesQuery)
            ->where('is_approved', false)
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        $calcChangePct = function (int $current, int $previous): float {
            if ($previous <= 0) {
                return $current > 0 ? 100.0 : 0.0;
            }

            return round((($current - $previous) / $previous) * 100, 2);
        };

        $metricCards = [
            [
                'label' => 'Total Properti',
                'value' => $propertiesTotal,
                'change_pct' => $calcChangePct($createdThisMonth, $createdPrevMonth),
                'positive' => $createdThisMonth >= $createdPrevMonth,
            ],
            [
                'label' => 'Pending Approval',
                'value' => $propertiesPendingApproval,
                'change_pct' => $calcChangePct($pendingCreatedThisMonth, $pendingCreatedPrevMonth),
                'positive' => $pendingCreatedThisMonth <= $pendingCreatedPrevMonth,
            ],
        ];

        $monthlyNewProperties = (clone $agentPropertiesQuery)
            ->selectRaw('MONTH(created_at) as m, COUNT(*) as c')
            ->whereYear('created_at', $year)
            ->groupBy('m')
            ->pluck('c', 'm')
            ->all();

        $monthlyPublishedProperties = (clone $agentPropertiesQuery)
            ->selectRaw('MONTH(created_at) as m, COUNT(*) as c')
            ->whereYear('created_at', $year)
            ->where('is_published', true)
            ->where('is_approved', true)
            ->groupBy('m')
            ->pluck('c', 'm')
            ->all();

        $fillMonths = function (array $map): array {
            $out = [];
            for ($i = 1; $i <= 12; $i++) {
                $out[] = (int)($map[$i] ?? 0);
            }
            return $out;
        };

        $chartCategories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $approvedThisMonth = (clone $agentPropertiesQuery)
            ->where('is_approved', true)
            ->whereNotNull('approved_at')
            ->whereYear('approved_at', $year)
            ->whereMonth('approved_at', $month)
            ->count();

        $approvalRateThisMonth = $createdThisMonth > 0
            ? round(($approvedThisMonth / $createdThisMonth) * 100, 2)
            : 0.0;

        $publishedThisMonth = (clone $agentPropertiesQuery)
            ->where('is_published', true)
            ->where('is_approved', true)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $createdToday = (clone $agentPropertiesQuery)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $approvalSummary = [
            'rate' => $approvalRateThisMonth,
            'approved_this_month' => $approvedThisMonth,
            'published_this_month' => $publishedThisMonth,
            'created_today' => $createdToday,
        ];

        $overallPublished = (clone $agentPropertiesQuery)
            ->where('is_published', true)
            ->where('is_approved', true)
            ->count();

        $topCitiesRaw = (clone $agentPropertiesQuery)
            ->select('city', DB::raw('COUNT(*) as total'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->where('is_published', true)
            ->where('is_approved', true)
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $countrySvgs = [
            '/assets/admin/images/country/country-01.svg',
            '/assets/admin/images/country/country-02.svg',
            '/assets/admin/images/country/country-03.svg',
            '/assets/admin/images/country/country-04.svg',
            '/assets/admin/images/country/country-05.svg',
        ];

        $topCities = $topCitiesRaw->values()->map(function ($row, int $idx) use ($overallPublished, $countrySvgs) {
            $total = (int)$row->total;
            $pct = $overallPublished > 0 ? (int)round(($total / $overallPublished) * 100) : 0;

            return [
                'name' => (string)$row->city,
                'flag' => $countrySvgs[$idx % count($countrySvgs)],
                'customers' => number_format($total, 0, ',', '.'),
                'percentage' => max(0, min(100, $pct)),
                'label' => 'Properti',
            ];
        })->all();

        $recentProperties = (clone $agentPropertiesQuery)
            ->with(['images', 'listingCategories'])
            ->latest()
            ->limit(6)
            ->get()
            ->map(function (Property $property) {
                $image = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                    ?? $property->images->sortBy('sort_order')->first()?->path
                    ?? 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=128';

                if (!empty($image) && !str_starts_with($image, 'http://') && !str_starts_with($image, 'https://') && !str_starts_with($image, '/')) {
                    $image = '/storage/' . ltrim($image, '/');
                }

                $status = 'Draft';
                if ($property->is_published && $property->is_approved) {
                    $status = 'Published';
                } elseif (!$property->is_approved) {
                    $status = 'Pending Approval';
                }

                $listingCats = ($property->listingCategories ?? collect())
                    ->sortBy('sort_order')
                    ->pluck('name')
                    ->take(2)
                    ->values()
                    ->all();

                return [
                    'name' => $property->title,
                    'variants' => $property->city ? $property->city : ($property->type ?: 1),
                    'image' => $image,
                    'category' => count($listingCats) ? implode(', ', $listingCats) : ($property->type ?? '-'),
                    'price' => $property->price ? ('Rp ' . number_format((float)$property->price, 0, ',', '.')) : '-',
                    'status' => $status,
                ];
            })
            ->all();

        $baseSubsidiQuery = Property::query()
            ->where('user_id', $agentId)
            ->whereHas('listingCategories', fn ($q) => $q->where('slug', 'rumah-subsidi'));

        $rumahSubsidiCount = (clone $baseSubsidiQuery)->count();
        $rumahSubsidiLatest = (clone $baseSubsidiQuery)
            ->with(['images'])
            ->latest()
            ->take(4)
            ->get();

        $dashboardData = [
            'chartOne' => [
                'series' => [
                    ['name' => 'Properti Baru', 'data' => $fillMonths($monthlyNewProperties)],
                ],
                'categories' => $chartCategories,
            ],
            'chartTwo' => [
                'value' => $approvalRateThisMonth,
            ],
            'chartThree' => [
                'series' => [
                    ['name' => 'Properti Terbit', 'data' => $fillMonths($monthlyPublishedProperties)],
                    ['name' => 'Artikel Terbit', 'data' => array_fill(0, 12, 0)],
                ],
                'categories' => $chartCategories,
            ],
        ];

        return view('agent.pages.dashboard.dashboard', [
            'title' => 'Dashboard',
            'rumahSubsidiCount' => $rumahSubsidiCount,
            'rumahSubsidiLatest' => $rumahSubsidiLatest,
            'agentProfile' => $agentProfile,
            'metricCards' => $metricCards,
            'approvalSummary' => $approvalSummary,
            'topCities' => $topCities,
            'recentProperties' => $recentProperties,
            'dashboardData' => $dashboardData,
            'counts' => [
                'mode' => 'agent',
                'published_total' => $propertiesPublishedTotal,
                'draft_total' => $propertiesDraftTotal,
                'rumah_subsidi_total' => $rumahSubsidiCount,
                'pending_total' => $propertiesPendingApproval,
            ],
        ]);
    }
}


