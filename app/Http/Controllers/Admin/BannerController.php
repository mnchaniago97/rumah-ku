<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $location = $request->get('location', 'hero');
        
        $banners = Banner::when($location, function($query) use ($location) {
                return $query->where('location', $location);
            })
            ->orderBy('sort_order')
            ->paginate(12);
            
        return view('admin.pages.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $location = $request->get('location', 'hero');
        return view('admin.pages.banner.create', compact('location'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|string|max:255',
            'position' => 'required|string|max:50',
            'location' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $imagePath = $request->file('image')->store('banners', 'uploads');

        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'link' => $request->link,
            'position' => $request->position,
            'location' => $request->location,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.pages.banner.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.pages.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|string|max:255',
            'position' => 'required|string|max:50',
            'location' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $data = [
            'title' => $request->title,
            'link' => $request->link,
            'position' => $request->position,
            'location' => $request->location,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image && Storage::disk('uploads')->exists($banner->image)) {
                Storage::disk('uploads')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'uploads');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);

        // Delete image
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil dihapus.');
    }
}
