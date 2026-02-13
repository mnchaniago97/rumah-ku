<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PropertyInquiryController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $inquiries = PropertyInquiry::query()
            ->with('handler')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.pages.property-inquiries.index', [
            'title' => 'Permintaan Properti',
            'inquiries' => $inquiries,
            'status' => $status,
        ]);
    }

    public function show(PropertyInquiry $propertyInquiry): View
    {
        $propertyInquiry->load('handler');

        return view('admin.pages.property-inquiries.show', [
            'title' => 'Detail Permintaan',
            'inquiry' => $propertyInquiry,
        ]);
    }

    public function update(Request $request, PropertyInquiry $propertyInquiry): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,contacted,closed'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($data['status'] === 'contacted' && $propertyInquiry->contacted_at === null) {
            $propertyInquiry->contacted_at = now();
        }

        if ($propertyInquiry->handled_by === null) {
            $propertyInquiry->handled_by = Auth::id();
        }

        $propertyInquiry->status = $data['status'];
        if (isset($data['notes'])) {
            $propertyInquiry->notes = $data['notes'];
        }

        $propertyInquiry->save();

        return back()->with('success', 'Data permintaan diperbarui.');
    }

    public function destroy(PropertyInquiry $propertyInquiry): RedirectResponse
    {
        $propertyInquiry->delete();

        return redirect()
            ->route('admin.property-inquiries.index')
            ->with('success', 'Permintaan dihapus.');
    }
}

