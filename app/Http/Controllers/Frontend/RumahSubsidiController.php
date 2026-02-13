<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RumahSubsidiController extends Controller
{
    public function index(): View
    {
        $subsidiProperties = Property::with(['images', 'listingCategories'])
            ->where('is_published', true)
            ->where('is_approved', true)
            ->whereHas('listingCategories', function ($query) {
                $query->where('slug', 'rumah-subsidi');
            })
            ->latest()
            ->get();

        return view('frontend.rumah-subsidi', [
            'title' => 'Rumah Subsidi',
            'properties' => $subsidiProperties,
        ]);
    }
}
