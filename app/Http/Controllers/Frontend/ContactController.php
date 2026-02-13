<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('frontend.contact', [
            'title' => 'Contact',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // TODO: validate and send contact message
        return redirect()
            ->back()
            ->with('success', 'Message sent (placeholder).');
    }
}
