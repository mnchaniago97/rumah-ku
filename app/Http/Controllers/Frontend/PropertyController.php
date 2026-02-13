<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(): View
    {
        $properties = Property::with(['images'])
            ->where('is_published', true)
            ->where('is_approved', true)
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'disewakan');
            })
            ->latest()
            ->get();

        return view('frontend.pages.property.index', [
            'title' => 'Properties',
            'properties' => $properties,
        ]);
    }

    public function show(string $permalink): View|RedirectResponse
    {
        $property = Property::with(['images', 'features', 'specifications', 'nearby', 'agent', 'category'])
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

        $query = Property::with(['images'])
            ->where('is_published', true)
            ->where('is_approved', true)
            ->when(!$request->filled('status'), function ($q) {
                $q->where(function ($qq) {
                    $qq->whereNull('status')
                        ->orWhere('status', '!=', 'disewakan');
                });
            });

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

        return view('frontend.pages.property.index', [
            'title' => 'Search Results',
            'properties' => $properties,
        ]);
    }
}
