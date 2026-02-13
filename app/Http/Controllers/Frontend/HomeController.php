<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Property;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProperties = Property::with(['images'])->where('is_featured', true)->latest()->take(8)->get();
        $latestProperties = Property::with(['images'])->latest()->take(8)->get();
        
        // Get active banners for home page by location
        $heroBanners = Banner::active()->byPosition('home')->byLocation('hero')->orderBy('sort_order')->get();
        $ads1Banners = Banner::active()->byPosition('home')->byLocation('ads_1')->orderBy('sort_order')->get();
        $ads2Banners = Banner::active()->byPosition('home')->byLocation('ads_2')->orderBy('sort_order')->get();
        $ads3Banners = Banner::active()->byPosition('home')->byLocation('ads_3')->orderBy('sort_order')->get();
        $bottomBanners = Banner::active()->byPosition('home')->byLocation('bottom')->orderBy('sort_order')->get();
        
        return view('frontend.home', [
            'title' => 'Rumah Ku - Temukan Rumah Impian Anda',
            'featuredProperties' => $featuredProperties,
            'latestProperties' => $latestProperties,
            'heroBanners' => $heroBanners,
            'ads1Banners' => $ads1Banners,
            'ads2Banners' => $ads2Banners,
            'ads3Banners' => $ads3Banners,
            'bottomBanners' => $bottomBanners,
        ]);
    }
}
