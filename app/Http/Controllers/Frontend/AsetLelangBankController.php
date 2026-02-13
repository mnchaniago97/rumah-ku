<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AsetLelangBankController extends Controller
{
    public function index(Request $request): View
    {
        $query = Property::with(['images', 'agent', 'listingCategories'])
            ->where('is_published', true)
            ->where('is_approved', true)
            ->whereHas('listingCategories', fn ($q) => $q->where('slug', 'aset-lelang-bank'));

        $q = trim((string) $request->query('q', ''));
        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', '%' . $q . '%')
                    ->orWhere('address', 'like', '%' . $q . '%')
                    ->orWhere('city', 'like', '%' . $q . '%')
                    ->orWhere('province', 'like', '%' . $q . '%');
            });
        }

        $city = trim((string) $request->query('city', ''));
        if ($city !== '') {
            $query->where('city', $city);
        }

        $type = trim((string) $request->query('type', ''));
        if ($type !== '') {
            $query->where('type', $type);
        }

        $priceMin = $request->query('price_min');
        if (is_numeric($priceMin)) {
            $query->where('price', '>=', (float) $priceMin);
        }

        $priceMax = $request->query('price_max');
        if (is_numeric($priceMax)) {
            $query->where('price', '<=', (float) $priceMax);
        }

        $properties = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $cityOptions = Property::query()
            ->where('is_published', true)
            ->where('is_approved', true)
            ->whereHas('listingCategories', fn ($q) => $q->where('slug', 'aset-lelang-bank'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return view('frontend.pages.aset-lelang-bank', [
            'title' => 'Aset Lelang Bank',
            'properties' => $properties,
            'cityOptions' => $cityOptions,
            'filters' => [
                'q' => $q,
                'city' => $city,
                'type' => $type,
                'price_min' => $priceMin,
                'price_max' => $priceMax,
            ],
        ]);
    }
}
