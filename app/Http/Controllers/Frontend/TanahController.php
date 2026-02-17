<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TanahController extends Controller
{
    public function index(Request $request): View
    {
        $query = Property::query()
            ->with(['images', 'category', 'user'])
            ->where('type', 'Tanah')
            ->where('status', 'dijual')
            ->where('is_approved', true);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('province', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('city', $request->location);
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $properties = $query->paginate(12)->withQueryString();

        // Get unique cities for filter
        $locations = Property::query()
            ->where('type', 'Tanah')
            ->where('status', 'dijual')
            ->where('is_approved', true)
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values();

        return view('frontend.pages.tanah-dijual', [
            'properties' => $properties,
            'locations' => $locations,
        ]);
    }
}
