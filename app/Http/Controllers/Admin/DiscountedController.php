<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Property;
use App\Models\PropertyListingCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscountedController extends Controller
{
    /**
     * Display a list of discounted properties.
     */
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        
        $properties = Property::with(['images', 'category', 'user', 'listingCategories'])
            ->where('is_discounted', true)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('title', 'like', '%' . $q . '%')
                        ->orWhere('address', 'like', '%' . $q . '%')
                        ->orWhere('city', 'like', '%' . $q . '%')
                        ->orWhere('province', 'like', '%' . $q . '%');
                });
            })
            ->latest()
            ->get();

        return view('admin.pages.discounted.index', [
            'title' => 'Aset Turun Harga',
            'properties' => $properties,
        ]);
    }

    /**
     * Show the form for creating a new discounted property.
     */
    public function create(): View
    {
        return view('admin.pages.discounted.create', [
            'title' => 'Tambah Aset Turun Harga',
            'listingCategories' => PropertyListingCategory::active()
                ->where('slug', '!=', 'rumah-subsidi')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'features' => Feature::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created discounted property.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:properties,slug'],
            'category_id' => ['nullable', 'integer'],
            'agent_id' => ['nullable', 'integer'],
            'price' => ['required', 'numeric'],
            'original_price' => ['required', 'numeric'],
            'price_period' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'string', 'max:50'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'bedrooms' => ['nullable', 'integer'],
            'bathrooms' => ['nullable', 'integer'],
            'floors' => ['nullable', 'integer'],
            'carports' => ['nullable', 'integer'],
            'garages' => ['nullable', 'integer'],
            'land_area' => ['nullable', 'integer'],
            'building_area' => ['nullable', 'integer'],
            'type' => ['nullable', 'string', 'max:50'],
            'certificate' => ['nullable', 'string', 'max:50'],
            'electricity' => ['nullable', 'string', 'max:20'],
            'water_source' => ['nullable', 'string', 'max:50'],
            'furnishing' => ['nullable', 'string', 'max:30'],
            'orientation' => ['nullable', 'string', 'max:30'],
            'year_built' => ['nullable', 'integer'],
            'description' => ['nullable', 'string'],
            'listing_category_ids' => ['nullable', 'array'],
            'listing_category_ids.*' => ['integer', 'exists:property_listing_categories,id'],
            'feature_ids' => ['nullable', 'array'],
            'feature_ids.*' => ['integer', 'exists:features,id'],
            'images.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $listingCategoryIds = collect($data['listing_category_ids'] ?? [])
            ->filter()
            ->unique()
            ->values()
            ->all();
        
        // Prevent rumah-subsidi category from being added
        $subsidiCategoryId = PropertyListingCategory::where('slug', 'rumah-subsidi')->value('id');
        if ($subsidiCategoryId) {
            $listingCategoryIds = array_values(array_diff($listingCategoryIds, [$subsidiCategoryId]));
        }
        
        unset($data['listing_category_ids']);

        $featureIds = collect($data['feature_ids'] ?? [])
            ->filter()
            ->unique()
            ->values()
            ->all();
        unset($data['feature_ids']);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        
        // Set as discounted
        $data['is_discounted'] = true;
        $data['discounted_at'] = now();
        
        $property = Property::create($data);

        if (count($listingCategoryIds) === 0) {
            $defaultCategoryId = PropertyListingCategory::query()
                ->where('slug', 'properti-baru')
                ->value('id');
            if ($defaultCategoryId) {
                $listingCategoryIds = [$defaultCategoryId];
            }
        }

        if (count($listingCategoryIds) > 0) {
            $property->listingCategories()->sync($listingCategoryIds);
        }

        if (count($featureIds) > 0) {
            $property->features()->sync($featureIds);
        }

        return redirect()
            ->route('admin.discounted.index')
            ->with('success', 'Aset turun harga created.');
    }

    /**
     * Show the form for editing a discounted property.
     */
    public function edit(Property $property): View
    {
        $property->load(['images', 'listingCategories']);

        return view('admin.pages.discounted.edit', [
            'title' => 'Edit Aset Turun Harga',
            'property' => $property,
        ]);
    }

    /**
     * Update the discounted property.
     */
    public function update(Request $request, Property $property): RedirectResponse
    {
        $data = $request->validate([
            'price' => ['nullable', 'numeric'],
            'original_price' => ['nullable', 'numeric'],
            'is_discounted' => ['nullable', 'boolean'],
        ]);

        $data['is_discounted'] = $request->boolean('is_discounted');

        // If unchecking discounted, clear the discounted_at
        if (!$data['is_discounted']) {
            $data['discounted_at'] = null;
        }

        $property->update($data);

        return redirect()
            ->route('admin.discounted.index')
            ->with('success', 'Aset turun harga updated.');
    }

    /**
     * Remove the discounted status from a property.
     */
    public function destroy(Property $property): RedirectResponse
    {
        $property->update([
            'is_discounted' => false,
            'discounted_at' => null,
            'original_price' => null,
        ]);

        return redirect()
            ->route('admin.discounted.index')
            ->with('success', 'Aset turun harga dihapus.');
    }
}
