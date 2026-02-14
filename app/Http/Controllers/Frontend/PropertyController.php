<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $baseQuery = Property::with(['images'])
            ->where('is_published', true)
            ->where('is_approved', true)
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'disewakan');
            });

        $query = clone $baseQuery;

        if ($request->filled('q')) {
            $q = trim((string) $request->q);
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', '%' . $q . '%')
                    ->orWhere('address', 'like', '%' . $q . '%')
                    ->orWhere('city', 'like', '%' . $q . '%')
                    ->orWhere('province', 'like', '%' . $q . '%');
            });
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        if ($request->filled('min_land_area')) {
            $query->where('land_area', '>=', $request->min_land_area);
        }
        if ($request->filled('max_land_area')) {
            $query->where('land_area', '<=', $request->max_land_area);
        }

        $sort = strtolower(trim((string) $request->get('sort', '')));
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'area_asc':
                $query->orderBy('land_area', 'asc');
                break;
            case 'area_desc':
                $query->orderBy('land_area', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $properties = $query->paginate(12)->withQueryString();

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

        return view('frontend.pages.property.index', [
            'title' => 'Properties',
            'properties' => $properties,
            'typeOptions' => $typeOptions,
            'cityOptions' => $cityOptions,
        ]);
    }

    public function show(string $permalink): View|RedirectResponse
    {
        $property = Property::with(['images', 'features', 'specifications', 'nearby', 'agent', 'category', 'user'])
            ->where('is_published', true)
            ->where('is_approved', true)
            ->where(function ($q) use ($permalink) {
                $q->where('slug', $permalink)->orWhere('id', $permalink);
            })
            ->firstOrFail();

        if (filled($property->slug) && $permalink !== $property->slug) {
            return redirect()
                ->route('property.show', $property->slug)
                ->setStatusCode(301);
        }

        $relatedQuery = Property::with(['images'])
            ->whereKeyNot($property->getKey())
            ->where('is_published', true)
            ->where('is_approved', true)
            ->when(
                strtolower(trim((string) $property->status)) === 'disewakan',
                fn ($q) => $q->where('status', 'disewakan'),
                fn ($q) => $q->where(function ($qq) {
                    $qq->whereNull('status')
                        ->orWhere('status', '!=', 'disewakan');
                })
            );

        $relatedProperties = $relatedQuery->latest()->take(6)->get();

        return view('frontend.pages.property.show', [
            'title' => 'Property Detail',
            'property' => $property,
            'relatedProperties' => $relatedProperties,
        ]);
    }

    public function search(Request $request): View|RedirectResponse
    {
        if ($request->filled('status') && strtolower(trim((string) $request->status)) === 'disewakan') {
            return redirect()->route('sewa', array_filter([
                'q' => $request->q,
                'type' => $request->type,
            ]));
        }

        return redirect()->route('properties', array_filter([
            'q' => $request->q,
            'type' => $request->type,
            'city' => $request->city,
        ]));
    }
}
