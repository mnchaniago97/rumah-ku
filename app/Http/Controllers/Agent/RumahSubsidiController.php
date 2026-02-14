<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyListingCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RumahSubsidiController extends Controller
{
    public function index(): View
    {
        $properties = Property::with(['images', 'listingCategories'])
            ->where('user_id', Auth::id())
            ->whereHas('listingCategories', function ($query) {
                $query->where('slug', 'rumah-subsidi');
            })
            ->latest()
            ->get();

        return view('agent.pages.rumah-subsidi.index', [
            'title' => 'Rumah Subsidi',
            'properties' => $properties,
        ]);
    }

    public function create(): View
    {
        $subsidiCategory = PropertyListingCategory::query()->where('slug', 'rumah-subsidi')->first();

        if (!$subsidiCategory) {
            PropertyListingCategory::query()->create([
                'name' => 'Rumah Subsidi',
                'slug' => 'rumah-subsidi',
                'is_active' => true,
                'sort_order' => 5,
            ]);
        }

        return view('agent.pages.rumah-subsidi.create', [
            'title' => 'Tambah Rumah Subsidi',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:properties,slug'],
            'price' => ['required', 'numeric'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
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
            'images.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['status'] = 'subsidi';
        $data['user_id'] = Auth::id();

        $data['is_approved'] = false;
        $data['approved_at'] = null;
        $data['approved_by'] = null;

        $property = Property::create($data);

        $subsidiCategoryId = PropertyListingCategory::query()->where('slug', 'rumah-subsidi')->value('id');
        if ($subsidiCategoryId) {
            $property->listingCategories()->sync([$subsidiCategoryId]);
        }

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $index => $file) {
                $path = $file->store('properties', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => Storage::url($path),
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }
            $property->save();
        }

        return redirect()
            ->route('agent.rumah-subsidi.index')
            ->with('success', 'Rumah subsidi berhasil ditambahkan. Menunggu persetujuan admin.');
    }

    public function edit(Property $rumah_subsidi): View
    {
        $rumah_subsidi->load(['images', 'listingCategories']);
        $this->authorizeRumahSubsidi($rumah_subsidi);

        return view('agent.pages.rumah-subsidi.edit', [
            'title' => 'Edit Rumah Subsidi',
            'property' => $rumah_subsidi,
        ]);
    }

    public function show(Property $rumah_subsidi): View
    {
        $rumah_subsidi->load(['images', 'listingCategories', 'user', 'category', 'agent', 'features', 'specifications']);
        $this->authorizeRumahSubsidi($rumah_subsidi);

        return view('agent.pages.rumah-subsidi.show', [
            'title' => 'Detail Rumah Subsidi',
            'property' => $rumah_subsidi,
        ]);
    }

    public function update(Request $request, Property $rumah_subsidi): RedirectResponse
    {
        $rumah_subsidi->load(['listingCategories']);
        $this->authorizeRumahSubsidi($rumah_subsidi);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:properties,slug,' . $rumah_subsidi->id],
            'price' => ['required', 'numeric'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
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
            'images.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['status'] = 'subsidi';
        $data['user_id'] = Auth::id();

        $data['is_approved'] = false;
        $data['approved_at'] = null;
        $data['approved_by'] = null;

        $rumah_subsidi->update($data);

        $subsidiCategoryId = PropertyListingCategory::query()->where('slug', 'rumah-subsidi')->value('id');
        if ($subsidiCategoryId) {
            $rumah_subsidi->listingCategories()->sync([$subsidiCategoryId]);
        }

        if ($request->hasFile('images')) {
            $startIndex = $rumah_subsidi->images()->max('sort_order') ?? 0;
            $files = $request->file('images');
            foreach ($files as $offset => $file) {
                $path = $file->store('properties', 'public');
                PropertyImage::create([
                    'property_id' => $rumah_subsidi->id,
                    'path' => Storage::url($path),
                    'sort_order' => $startIndex + $offset + 1,
                    'is_primary' => $rumah_subsidi->images()->count() === 0 && $offset === 0,
                ]);
            }
            $rumah_subsidi->save();
        }

        return redirect()
            ->route('agent.rumah-subsidi.index')
            ->with('success', 'Rumah subsidi berhasil diperbarui. Menunggu persetujuan admin.');
    }

    public function destroy(Property $rumah_subsidi): RedirectResponse
    {
        $rumah_subsidi->load(['images', 'listingCategories']);
        $this->authorizeRumahSubsidi($rumah_subsidi);

        foreach ($rumah_subsidi->images as $image) {
            $rawPath = (string) $image->path;
            $relative = $rawPath;
            if (str_starts_with($relative, '/storage/')) {
                $relative = ltrim(str_replace('/storage/', '', $relative), '/');
            } elseif (str_starts_with($relative, 'http://') || str_starts_with($relative, 'https://')) {
                $parsed = parse_url($relative, PHP_URL_PATH);
                $relative = is_string($parsed) ? ltrim(str_replace('/storage/', '', $parsed), '/') : $relative;
            } else {
                $relative = ltrim($relative, '/');
            }

            if ($relative !== '') {
                Storage::disk('public')->delete($relative);
            }
            $image->delete();
        }

        if (method_exists($rumah_subsidi, 'features')) {
            $rumah_subsidi->features()->detach();
        }

        $rumah_subsidi->listingCategories()->detach();
        $rumah_subsidi->delete();

        return redirect()
            ->route('agent.rumah-subsidi.index')
            ->with('success', 'Rumah subsidi berhasil dihapus.');
    }

    private function authorizeRumahSubsidi(Property $property): void
    {
        if (!$property->listingCategories->contains('slug', 'rumah-subsidi')) {
            abort(404);
        }

        if ($property->user_id !== Auth::id()) {
            abort(403);
        }
    }
}

