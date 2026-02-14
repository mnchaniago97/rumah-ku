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

class SewaController extends Controller
{
    public function index(): View
    {
        $properties = Property::with(['images', 'listingCategories'])
            ->where('user_id', Auth::id())
            ->where('status', 'disewakan')
            ->latest()
            ->get();

        return view('agent.pages.sewa.index', [
            'title' => 'Properti Sewa',
            'properties' => $properties,
        ]);
    }

    public function create(): View
    {
        $sewaCategory = PropertyListingCategory::query()->where('slug', 'sewa')->first();
        if (!$sewaCategory) {
            PropertyListingCategory::query()->create([
                'name' => 'Sewa',
                'slug' => 'sewa',
                'is_active' => true,
                'sort_order' => 6,
            ]);
        }

        return view('agent.pages.sewa.create', [
            'title' => 'Tambah Properti Sewa',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $isVerified = $user ? $user->isAgentVerified() : false;

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:properties,slug'],
            'price' => ['required', 'numeric'],
            'price_period' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'whatsapp_phone' => ['nullable', 'string', 'max:50'],
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
        $data['status'] = 'disewakan';
        $data['user_id'] = Auth::id();

        if ($data['is_published'] && $isVerified) {
            $data['is_approved'] = true;
            $data['approved_at'] = now();
            $data['approved_by'] = null;
        } else {
            $data['is_approved'] = false;
            $data['approved_at'] = null;
            $data['approved_by'] = null;
        }

        $property = Property::create($data);

        $sewaCategoryId = PropertyListingCategory::query()->where('slug', 'sewa')->value('id');
        if ($sewaCategoryId) {
            $property->listingCategories()->sync([$sewaCategoryId]);
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
        }

        return redirect()
            ->route('agent.sewa.index')
            ->with('success', 'Properti sewa berhasil dibuat.');
    }

    public function show(Property $sewa): View
    {
        $this->authorizeSewa($sewa);
        $sewa->load(['images', 'listingCategories']);

        return view('agent.pages.sewa.show', [
            'title' => 'Detail Properti Sewa',
            'property' => $sewa,
        ]);
    }

    public function edit(Property $sewa): View
    {
        $this->authorizeSewa($sewa);
        $sewa->load(['images', 'listingCategories']);

        return view('agent.pages.sewa.edit', [
            'title' => 'Edit Properti Sewa',
            'property' => $sewa,
        ]);
    }

    public function update(Request $request, Property $sewa): RedirectResponse
    {
        $this->authorizeSewa($sewa);

        $user = Auth::user();
        $isVerified = $user ? $user->isAgentVerified() : false;

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:properties,slug,' . $sewa->id],
            'price' => ['required', 'numeric'],
            'price_period' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'whatsapp_phone' => ['nullable', 'string', 'max:50'],
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
        $data['status'] = 'disewakan';
        $data['user_id'] = Auth::id();

        if ($data['is_published']) {
            if ($isVerified) {
                $data['is_approved'] = true;
                if (!$sewa->is_approved || !$sewa->approved_at) {
                    $data['approved_at'] = now();
                    $data['approved_by'] = null;
                } else {
                    unset($data['approved_at'], $data['approved_by']);
                }
            } else {
                $data['is_approved'] = false;
                $data['approved_at'] = null;
                $data['approved_by'] = null;
            }
        } else {
            unset($data['is_approved'], $data['approved_at'], $data['approved_by']);
        }

        $sewa->update($data);

        $sewaCategoryId = PropertyListingCategory::query()->where('slug', 'sewa')->value('id');
        if ($sewaCategoryId) {
            $sewa->listingCategories()->sync([$sewaCategoryId]);
        }

        if ($request->hasFile('images')) {
            $startIndex = $sewa->images()->max('sort_order') ?? 0;
            $files = $request->file('images');
            foreach ($files as $offset => $file) {
                $path = $file->store('properties', 'public');
                PropertyImage::create([
                    'property_id' => $sewa->id,
                    'path' => Storage::url($path),
                    'sort_order' => $startIndex + $offset + 1,
                    'is_primary' => $sewa->images()->count() === 0 && $offset === 0,
                ]);
            }
        }

        return redirect()
            ->route('agent.sewa.index')
            ->with('success', 'Properti sewa berhasil diperbarui.');
    }

    public function destroy(Property $sewa): RedirectResponse
    {
        $this->authorizeSewa($sewa);
        $sewa->load(['images', 'listingCategories']);

        foreach ($sewa->images as $image) {
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

        if (method_exists($sewa, 'features')) {
            $sewa->features()->detach();
        }

        $sewa->listingCategories()->detach();
        $sewa->delete();

        return redirect()
            ->route('agent.sewa.index')
            ->with('success', 'Properti sewa berhasil dihapus.');
    }

    private function authorizeSewa(Property $property): void
    {
        if ($property->user_id !== Auth::id()) {
            abort(403);
        }

        if (strtolower(trim((string) $property->status)) !== 'disewakan') {
            abort(404);
        }
    }
}

