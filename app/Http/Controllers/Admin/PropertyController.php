<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyListingCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $escaped = addcslashes($q, '\\%_');
        $like = '%' . $escaped . '%';

        $properties = Property::with(['images', 'category', 'user', 'listingCategories'])
            ->whereDoesntHave('listingCategories', function ($query) {
                $query->where('slug', 'rumah-subsidi');
            })
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'disewakan');
            })
            ->when($q !== '', function ($query) use ($like) {
                $query->where(function ($query) use ($like) {
                    $query->where('title', 'like', $like)
                        ->orWhere('slug', 'like', $like)
                        ->orWhere('address', 'like', $like)
                        ->orWhere('city', 'like', $like)
                        ->orWhere('province', 'like', $like);
                });
            })
            ->latest()
            ->get();

        return view('admin.pages.property.index', [
            'title' => 'Properti Dijual',
            'properties' => $properties,
        ]);
    }

    public function create(): View
    {
        return view('admin.pages.property.create', [
            'title' => 'Create Property',
            'listingCategories' => PropertyListingCategory::active()
                ->where('slug', '!=', 'rumah-subsidi')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'features' => Feature::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:properties,slug'],
            'category_id' => ['nullable', 'integer'],
            'agent_id' => ['nullable', 'integer'],
            'price' => ['nullable', 'numeric'],
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
        
        // Prevent rumah-subsidi category from being added via regular property form
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
        
        // Set the user_id to the authenticated admin user
        $data['user_id'] = Auth::id();
        
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

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $index => $file) {
                $path = $file->store('properties', 'uploads');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => '/storage/' . $path,
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
                
            }
            $property->save();
        }

       
        
        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property created.');
    }

    public function show(Property $property): View
    {
        $property->load(['images', 'category', 'agent', 'user', 'listingCategories', 'features', 'nearby', 'specifications', 'videos', 'documents', 'projects']);

        return view('admin.pages.property.show', [
            'title' => 'Property Detail',
            'property' => $property,
        ]);
    }

    public function edit(Property $property): View
    {
        $property->load(['listingCategories', 'features']);

        return view('admin.pages.property.edit', [
            'title' => 'Edit Property',
            'property' => $property,
            'listingCategories' => PropertyListingCategory::active()
                ->where('slug', '!=', 'rumah-subsidi')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'features' => Feature::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Property $property): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:properties,slug,' . $property->id],
            'category_id' => ['nullable', 'integer'],
            'agent_id' => ['nullable', 'integer'],
            'price' => ['nullable', 'numeric'],
            'price_period' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'string', 'max:50'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'listing_duration_months' => ['nullable', 'integer', 'min:1', 'max:12'],
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
        
        // Prevent rumah-subsidi category from being added via regular property form
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

        // Handle listing duration
        if (isset($data['listing_duration_months']) && $data['listing_duration_months'] > 0) {
            $data['listing_expires_at'] = now()->addMonths((int) $data['listing_duration_months']);
        }
        unset($data['listing_duration_months']);

        $property->update($data);

        $property->listingCategories()->sync($listingCategoryIds);
        $property->features()->sync($featureIds);

        if ($request->hasFile('images')) {
            $startIndex = $property->images()->max('sort_order') ?? 0;
            $files = $request->file('images');
            foreach ($files as $offset => $file) {
                $path = $file->store('properties', 'uploads');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => '/storage/' . $path,
                    'sort_order' => $startIndex + $offset + 1,
                    'is_primary' => $property->images()->count() === 0 && $offset === 0,
                ]);
            }
            $property->save();
        }

        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property updated.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->delete();

        return redirect()
            ->route('admin.properties.index')
            ->with('success', 'Property deleted.');
    }

    public function approve(Property $property): RedirectResponse
    {
        $property->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Property disetujui.');
    }

    public function reject(Property $property): RedirectResponse
    {
        $property->update([
            'is_approved' => false,
            'approved_at' => null,
            'approved_by' => null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Property ditolak / perlu revisi.');
    }
}
