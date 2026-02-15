<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:2000'],
        ], [], [
            'name' => 'Nama',
            'email' => 'Email',
            'phone' => 'Telepon/WhatsApp',
            'subject' => 'Subjek',
            'message' => 'Pesan',
        ]);

        ContactMessage::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        Log::info('Contact form submitted', [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Pesan Anda sudah terkirim. Tim kami akan menghubungi Anda secepatnya.');
    }
}
