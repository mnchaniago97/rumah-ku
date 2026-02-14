<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SewaController extends Controller
{
    public function index(Request $request, ?string $shortcut = null): View|RedirectResponse
    {
        $shortcut = $shortcut ? strtolower(trim($shortcut)) : null;

        $shortcutMap = [
            'rumah' => ['type' => 'Rumah'],
            'kost' => ['type_label' => 'Kost', 'types' => ['kost', 'kos', 'kos-kosan', 'kost-kosan']],
            'villa' => ['type' => 'Villa'],
            'ruko' => ['type' => 'Ruko'],
            'tanah' => ['type' => 'Tanah'],
            'bulanan' => ['period' => 'bulan'],
            'tahunan' => ['period' => 'tahun'],
        ];

        if ($shortcut === 'bantuan') {
            return view('frontend.pages.sewa-help', [
                'title' => 'Bantuan Sewa',
            ]);
        }

        if ($shortcut === 'apartemen') {
            return redirect()->route('sewa.shortcut', array_merge(['shortcut' => 'kost'], $request->query()));
        }

        $forcedType = null;
        $forcedTypes = null;
        $forcedPeriod = null;
        if ($shortcut && isset($shortcutMap[$shortcut])) {
            $forcedType = $shortcutMap[$shortcut]['type'] ?? ($shortcutMap[$shortcut]['type_label'] ?? null);
            $forcedTypes = $shortcutMap[$shortcut]['types'] ?? null;
            $forcedPeriod = $shortcutMap[$shortcut]['period'] ?? null;
        }

        $baseQuery = Property::with(['images', 'listingCategories', 'agent', 'user'])
            ->where('is_published', true)
            ->where('is_approved', true)
            ->where('status', 'disewakan');

        $query = clone $baseQuery;

        if ($forcedTypes && count($forcedTypes)) {
            $query->whereNotNull('type')
                ->where('type', '!=', '')
                ->whereIn(DB::raw('LOWER(type)'), $forcedTypes);
        } elseif ($forcedType) {
            $query->where('type', $forcedType);
        }

        if ($forcedPeriod) {
            $query->where('price_period', $forcedPeriod);
        }

        // Search
        if ($request->filled('q')) {
            $q = trim((string) $request->q);
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', '%' . $q . '%')
                    ->orWhere('address', 'like', '%' . $q . '%')
                    ->orWhere('city', 'like', '%' . $q . '%')
                    ->orWhere('province', 'like', '%' . $q . '%');
            });
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter by property type
        if (!$forcedType && !$forcedTypes && $request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by price period
        if (!$forcedPeriod && $request->filled('period')) {
            $query->where('price_period', $request->period);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Filter by bathrooms
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        $properties = $query->latest()->paginate(12)->withQueryString();

        $typeOptions = (clone $baseQuery)
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        if ($typeOptions->isEmpty()) {
            $typeOptions = collect(['Rumah', 'Apartemen', 'Kost', 'Villa', 'Ruko', 'Kantor', 'Tanah'])->values();
        }

        $cityOptions = (clone $baseQuery)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $popularCityRows = (clone $baseQuery)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->take(8)
            ->get();

        $popularCities = $popularCityRows->map(function ($row) use ($baseQuery) {
            $sampleProperty = (clone $baseQuery)
                ->where('city', $row->city)
                ->with(['images'])
                ->latest()
                ->first();

            $image = $sampleProperty?->images?->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                ?? $sampleProperty?->images?->sortBy('sort_order')->first()?->path;

            return [
                'city' => $row->city,
                'total' => (int) $row->total,
                'image' => $image,
            ];
        });

        $takeLatestByTypes = function (array $types) use ($baseQuery) {
            $types = array_values(array_filter(array_map('strtolower', $types)));
            if (count($types) === 0) {
                return collect();
            }

            return (clone $baseQuery)
                ->whereNotNull('type')
                ->where('type', '!=', '')
                ->whereIn(DB::raw('LOWER(type)'), $types)
                ->latest()
                ->take(8)
                ->get();
        };

        $recommendedProperties = (clone $baseQuery)->latest()->take(8)->get();
        $houseRentals = $takeLatestByTypes(['Rumah']);
        $apartmentRentals = $takeLatestByTypes(['Apartemen']);
        $kostRentals = $takeLatestByTypes(['Kost', 'Kos', 'Kos-kosan', 'Kost-kosan']);
        $businessRentals = $takeLatestByTypes(['Ruko', 'Kantor', 'Gudang', 'Pabrik', 'Ruang Usaha', 'Toko']);
        $villaRentals = $takeLatestByTypes(['Villa']);
        $articles = Article::published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(4)
            ->get();

        $listingMode = $shortcut !== null
            || $request->filled('q')
            || $request->filled('city')
            || $request->filled('type')
            || $request->filled('period')
            || $request->filled('min_price')
            || $request->filled('max_price')
            || $request->filled('bedrooms')
            || $request->filled('bathrooms');

        return view('frontend.pages.sewa', [
            'title' => 'Properti Disewa',
            'listingMode' => $listingMode,
            'activeShortcut' => $shortcut,
            'forcedType' => $forcedType,
            'forcedTypes' => $forcedTypes,
            'forcedPeriod' => $forcedPeriod,
            'properties' => $properties,
            'typeOptions' => $typeOptions,
            'cityOptions' => $cityOptions,
            'popularCities' => $popularCities,
            'recommendedProperties' => $recommendedProperties,
            'houseRentals' => $houseRentals,
            'apartmentRentals' => $apartmentRentals,
            'kostRentals' => $kostRentals,
            'businessRentals' => $businessRentals,
            'villaRentals' => $villaRentals,
            'articles' => $articles,
        ]);
    }
}
