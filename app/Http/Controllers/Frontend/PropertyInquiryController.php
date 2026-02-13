<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PropertyInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PropertyInquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'intent' => ['required', 'in:buy,rent'],
            'property_types' => ['nullable', 'array'],
            'property_types.*' => ['string', 'max:50'],
            'location' => ['nullable', 'string', 'max:120'],
            'price_min' => ['nullable', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'numeric', 'min:0'],
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'wants_kpr' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $data['wants_kpr'] = $request->boolean('wants_kpr');
        $data['status'] = 'new';
        $data['page_url'] = $request->fullUrl();
        $data['referrer'] = $request->headers->get('referer');
        $data['ip_address'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        PropertyInquiry::create($data);

        return back()->with('success', 'Permintaan Anda sudah kami terima. Tim kami akan segera menghubungi Anda.');
    }
}

