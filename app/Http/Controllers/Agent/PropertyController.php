<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(): View
    {
        $properties = Property::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('agent.pages.property.index', [
            'title' => 'Properties',
            'properties' => $properties,
        ]);
    }

    public function create(): View
    {
        return view('agent.pages.property.create', [
            'title' => 'Create Property',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
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
            'images.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['user_id'] = Auth::id();
        unset($data['agent_id']);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');

        $property = Property::create($data);

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
            ->route('agent.properties.index')
            ->with('success', 'Property created.');
    }

    public function show(Property $property): View
    {
        $this->authorizeProperty($property);

        return view('agent.pages.property.show', [
            'title' => 'Property Detail',
            'property' => $property,
        ]);
    }

    public function edit(Property $property): View
    {
        $this->authorizeProperty($property);

        return view('agent.pages.property.edit', [
            'title' => 'Edit Property',
            'property' => $property,
        ]);
    }

    public function update(Request $request, Property $property): RedirectResponse
    {
        $this->authorizeProperty($property);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
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
            'images.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['user_id'] = Auth::id();
        unset($data['agent_id']);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');

        $property->update($data);

        if ($request->hasFile('images')) {
            $startIndex = $property->images()->max('sort_order') ?? 0;
            $files = $request->file('images');
            foreach ($files as $offset => $file) {
                $path = $file->store('properties', 'public');
                PropertyImage::create([
                    'property_id' => $property->id,
                    'path' => Storage::url($path),
                    'sort_order' => $startIndex + $offset + 1,
                    'is_primary' => $property->images()->count() === 0 && $offset === 0,
                ]);
            }
        }

        return redirect()
            ->route('agent.properties.index')
            ->with('success', 'Property updated.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $this->authorizeProperty($property);

        $property->delete();

        return redirect()
            ->route('agent.properties.index')
            ->with('success', 'Property deleted.');
    }

    private function authorizeProperty(Property $property): void
    {
        if ($property->user_id !== Auth::id()) {
            abort(403);
        }
    }
}


