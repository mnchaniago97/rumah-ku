<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PropertyImageController extends Controller
{
    public function destroy(Property $property, PropertyImage $image): RedirectResponse
    {
        // Verify the image belongs to this property
        if ($image->property_id !== $property->id) {
            return redirect()
                ->route('admin.properties.show', $property)
                ->with('error', 'Image not found.');
        }

        // Delete the file from storage
        $path = str_replace('/storage', '', $image->path);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Delete the image record
        $image->delete();

        // Determine redirect based on route name
        $routeName = request()->route()->getName();
        
        if (str_contains($routeName, 'rumah-subsidi')) {
            return redirect()
                ->route('admin.rumah-subsidi.show', $property)
                ->with('success', 'Image deleted successfully.');
        } elseif (str_contains($routeName, 'sewa')) {
            return redirect()
                ->route('admin.sewa.show', $property)
                ->with('success', 'Image deleted successfully.');
        }

        return redirect()
            ->route('admin.properties.show', $property)
            ->with('success', 'Image deleted successfully.');
    }
}
