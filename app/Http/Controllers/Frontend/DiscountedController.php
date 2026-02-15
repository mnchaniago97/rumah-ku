<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscountedController extends Controller
{
    public function index(Request $request): View
    {
        $baseQuery = Property::with(['images', 'agent', 'listingCategories'])
            ->where('is_published', true)
            ->where('is_approved', true)
            ->where('is_discounted', true)
            ->forSale();

        $query = clone $baseQuery;

        // Search filter
        $q = trim((string) $request->query('q', ''));
        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', '%' . $q . '%')
                    ->orWhere('address', 'like', '%' . $q . '%')
                    ->orWhere('city', 'like', '%' . $q . '%')
                    ->orWhere('province', 'like', '%' . $q . '%');
            });
        }

        // City filter
        $city = trim((string) $request->query('city', ''));
        if ($city !== '') {
            $query->where('city', $city);
        }

        // Type filter
        $type = trim((string) $request->query('type', ''));
        if ($type !== '') {
            $query->where('type', $type);
        }

        // Sort options
        $sort = trim((string) $request->query('sort', 'discount_desc'));
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'discount_desc':
            default:
                // Sort by discount percentage (largest first) - using discounted_at as proxy
                $query->orderBy('discounted_at', 'desc');
                break;
        }

        $properties = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        // Get unique cities for filter
        $cityOptions = (clone $baseQuery)
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        // Get unique types for filter
        $typeOptions = (clone $baseQuery)
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view('frontend.pages.discounted', [
            'title' => 'Properti Turun Harga',
            'properties' => $properties,
            'cityOptions' => $cityOptions,
            'typeOptions' => $typeOptions,
            'filters' => [
                'q' => $q,
                'city' => $city,
                'type' => $type,
                'sort' => $sort,
            ],
        ]);
    }
}
