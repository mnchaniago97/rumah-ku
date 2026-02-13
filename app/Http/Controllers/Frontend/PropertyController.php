<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(): View
    {
        $properties = Property::with(['images'])->latest()->get();

        return view('frontend.property.index', [
            'title' => 'Properties',
            'properties' => $properties,
        ]);
    }

    public function show(string $permalink): View
    {
        $property = Property::with(['images', 'features', 'specifications', 'nearby', 'agent', 'category'])
            ->where('slug', $permalink)
            ->orWhere('id', $permalink)
            ->firstOrFail();

        $relatedProperties = Property::with(['images'])
            ->whereKeyNot($property->getKey())
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.property.show', [
            'title' => 'Property Detail',
            'property' => $property,
            'relatedProperties' => $relatedProperties,
        ]);
    }

    public function search(Request $request): View
    {
        $query = Property::with(['images']);

        if ($request->has('q') && !empty($request->q)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('address', 'like', '%' . $request->q . '%')
                  ->orWhere('city', 'like', '%' . $request->q . '%')
                  ->orWhere('province', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $properties = $query->latest()->get();

        return view('frontend.property.index', [
            'title' => 'Search Results',
            'properties' => $properties,
        ]);
    }
}
