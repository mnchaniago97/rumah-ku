<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Property;
use App\Models\PropertyListingCategory;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $baseQuery = Property::with(['images'])
            ->where('is_published', true)
            ->where('is_approved', true);

        $rekomendasiId = PropertyListingCategory::query()
            ->active()
            ->where('slug', 'rekomendasi')
            ->value('id');

        $pilihanKamiId = PropertyListingCategory::query()
            ->active()
            ->where('slug', 'pilihan-kami')
            ->value('id');

        $populerId = PropertyListingCategory::query()
            ->active()
            ->where('slug', 'properti-populer')
            ->value('id');

        $recommendedProperties = (clone $baseQuery)
            ->when($rekomendasiId, function ($q) use ($rekomendasiId) {
                $q->whereHas('listingCategories', fn ($qq) => $qq->where('property_listing_categories.id', $rekomendasiId));
            }, function ($q) {
                $q->where('is_featured', true);
            })
            ->latest()
            ->take(8)
            ->get();

        $ourChoiceProperties = (clone $baseQuery)
            ->when($pilihanKamiId, function ($q) use ($pilihanKamiId) {
                $q->whereHas('listingCategories', fn ($qq) => $qq->where('property_listing_categories.id', $pilihanKamiId));
            }, function ($q) {
                $q->where('is_featured', true);
            })
            ->latest()
            ->take(4)
            ->get();

        $popularProperties = (clone $baseQuery)
            ->when($populerId, function ($q) use ($populerId) {
                $q->whereHas('listingCategories', fn ($qq) => $qq->where('property_listing_categories.id', $populerId));
            })
            ->latest()
            ->take(8)
            ->get();

        if ($popularProperties->isEmpty()) {
            $popularProperties = (clone $baseQuery)
                ->latest()
                ->take(8)
                ->get();
        }

        $testimonials = Testimonial::active()
            ->orderBy('sort_order')
            ->latest()
            ->take(3)
            ->get();

        $articles = Article::published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->take(4)
            ->get();
        
        // Get active banners for home page by location
        $heroBanners = Banner::active()->byPosition('home')->byLocation('hero')->orderBy('sort_order')->get();
        $ads1Banners = Banner::active()->byPosition('home')->byLocation('ads_1')->orderBy('sort_order')->get();
        $ads2Banners = Banner::active()->byPosition('home')->byLocation('ads_2')->orderBy('sort_order')->get();
        $ads3Banners = Banner::active()->byPosition('home')->byLocation('ads_3')->orderBy('sort_order')->get();
        $bottomBanners = Banner::active()->byPosition('home')->byLocation('bottom')->orderBy('sort_order')->get();
        
        return view('frontend.pages.home', [
            'title' => 'Rumah Ku - Temukan Rumah Impian Anda',
            'recommendedProperties' => $recommendedProperties,
            'ourChoiceProperties' => $ourChoiceProperties,
            'popularProperties' => $popularProperties,
            'testimonials' => $testimonials,
            'articles' => $articles,
            'heroBanners' => $heroBanners,
            'ads1Banners' => $ads1Banners,
            'ads2Banners' => $ads2Banners,
            'ads3Banners' => $ads3Banners,
            'bottomBanners' => $bottomBanners,
        ]);
    }
}
