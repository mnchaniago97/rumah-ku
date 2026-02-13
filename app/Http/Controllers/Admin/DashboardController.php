<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $year = now()->year;
        $month = now()->month;

        $propertiesTotal = Property::query()->count();
        $propertiesPendingApproval = Property::query()->where('is_approved', false)->count();

        $usersTotal = User::query()->count();
        $agentsTotal = User::query()->where('role', 'agent')->count();

        $articlesPublishedTotal = Article::query()->published()->count();
        $bannersActiveTotal = Banner::query()->active()->count();

        $createdThisMonth = Property::query()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $createdPrevMonth = Property::query()
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        $pendingCreatedThisMonth = Property::query()
            ->where('is_approved', false)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $pendingCreatedPrevMonth = Property::query()
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

        $monthlyNewProperties = Property::query()
            ->selectRaw('MONTH(created_at) as m, COUNT(*) as c')
            ->whereYear('created_at', $year)
            ->groupBy('m')
            ->pluck('c', 'm')
            ->all();

        $monthlyPublishedProperties = Property::query()
            ->selectRaw('MONTH(created_at) as m, COUNT(*) as c')
            ->whereYear('created_at', $year)
            ->where('is_published', true)
            ->where('is_approved', true)
            ->groupBy('m')
            ->pluck('c', 'm')
            ->all();

        $monthlyPublishedArticles = Article::query()
            ->selectRaw('MONTH(published_at) as m, COUNT(*) as c')
            ->whereNotNull('published_at')
            ->whereYear('published_at', $year)
            ->where('is_published', true)
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

        $approvedThisMonth = Property::query()
            ->where('is_approved', true)
            ->whereNotNull('approved_at')
            ->whereYear('approved_at', $year)
            ->whereMonth('approved_at', $month)
            ->count();

        $approvalRateThisMonth = $createdThisMonth > 0
            ? round(($approvedThisMonth / $createdThisMonth) * 100, 2)
            : 0.0;

        $publishedThisMonth = Property::query()
            ->where('is_published', true)
            ->where('is_approved', true)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $createdToday = Property::query()
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $approvalSummary = [
            'rate' => $approvalRateThisMonth,
            'approved_this_month' => $approvedThisMonth,
            'published_this_month' => $publishedThisMonth,
            'created_today' => $createdToday,
        ];

        $overallPublished = Property::query()
            ->where('is_published', true)
            ->where('is_approved', true)
            ->count();

        $topCitiesRaw = Property::query()
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

        $recentProperties = Property::query()
            ->with(['images', 'listingCategories', 'user'])
            ->latest()
            ->limit(6)
            ->get()
            ->map(function (Property $property) {
                $image = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                    ?? $property->images->sortBy('sort_order')->first()?->path
                    ?? 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=128';

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
                    ['name' => 'Artikel Terbit', 'data' => $fillMonths($monthlyPublishedArticles)],
                ],
                'categories' => $chartCategories,
            ],
        ];

        return view('admin.pages.dashboard.ecommerce', [
            'title' => 'Dashboard',
            'metricCards' => $metricCards,
            'approvalSummary' => $approvalSummary,
            'topCities' => $topCities,
            'recentProperties' => $recentProperties,
            'dashboardData' => $dashboardData,
            'counts' => [
                'users_total' => $usersTotal,
                'agents_total' => $agentsTotal,
                'articles_published_total' => $articlesPublishedTotal,
                'banners_active_total' => $bannersActiveTotal,
            ],
        ]);
    }
}
