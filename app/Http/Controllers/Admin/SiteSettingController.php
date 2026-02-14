<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.pages.site-settings.edit', [
            'title' => 'Pengaturan Website',
            'settings' => SiteSettings::get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'about.title' => ['required', 'string', 'max:150'],
            'about.subtitle' => ['nullable', 'string', 'max:200'],
            'about.heading' => ['nullable', 'string', 'max:150'],
            'about.content' => ['nullable', 'string', 'max:5000'],

            'contact.title' => ['required', 'string', 'max:150'],
            'contact.subtitle' => ['nullable', 'string', 'max:200'],
            'contact.address' => ['nullable', 'string', 'max:300'],
            'contact.phone' => ['nullable', 'string', 'max:80'],
            'contact.whatsapp' => ['nullable', 'string', 'max:80'],
            'contact.whatsapp_link' => ['nullable', 'string', 'max:255'],
            'contact.email' => ['nullable', 'string', 'max:150'],
            'contact.hours' => ['nullable', 'string', 'max:200'],
            'contact.notes' => ['nullable', 'string', 'max:200'],
            'contact.maps_embed_html' => ['nullable', 'string'],

            'footer.brand' => ['required', 'string', 'max:80'],
            'footer.description' => ['nullable', 'string', 'max:1000'],
            'footer.socials' => ['array'],
            'footer.socials.facebook' => ['nullable', 'string', 'max:255'],
            'footer.socials.instagram' => ['nullable', 'string', 'max:255'],
            'footer.socials.twitter' => ['nullable', 'string', 'max:255'],
            'footer.socials.youtube' => ['nullable', 'string', 'max:255'],
            'footer.socials.linkedin' => ['nullable', 'string', 'max:255'],
            'footer.socials.whatsapp' => ['nullable', 'string', 'max:255'],

            'footer.quick_links' => ['array'],
            'footer.quick_links.*.label' => ['nullable', 'string', 'max:80'],
            'footer.quick_links.*.url' => ['nullable', 'string', 'max:255'],

            'footer.contact.address' => ['nullable', 'string', 'max:300'],
            'footer.contact.phone' => ['nullable', 'string', 'max:80'],
            'footer.contact.email' => ['nullable', 'string', 'max:150'],
            'footer.contact.whatsapp' => ['nullable', 'string', 'max:80'],

            'footer.copyright' => ['nullable', 'string', 'max:200'],
            'footer.legal_links' => ['array'],
            'footer.legal_links.*.label' => ['nullable', 'string', 'max:80'],
            'footer.legal_links.*.url' => ['nullable', 'string', 'max:255'],

            'legal.privacy_policy.title' => ['nullable', 'string', 'max:150'],
            'legal.privacy_policy.content' => ['nullable', 'string', 'max:10000'],
            'legal.terms.title' => ['nullable', 'string', 'max:150'],
            'legal.terms.content' => ['nullable', 'string', 'max:10000'],
            'legal.agent_terms.title' => ['nullable', 'string', 'max:150'],
            'legal.agent_terms.content' => ['nullable', 'string', 'max:10000'],
            'legal.community_guideline.title' => ['nullable', 'string', 'max:150'],
            'legal.community_guideline.content' => ['nullable', 'string', 'max:10000'],
        ]);

        $footer = $data['footer'] ?? [];
        $footer['quick_links'] = array_values(array_filter($footer['quick_links'] ?? [], function ($row) {
            return filled($row['label'] ?? null) && filled($row['url'] ?? null);
        }));
        $footer['legal_links'] = array_values(array_filter($footer['legal_links'] ?? [], function ($row) {
            return filled($row['label'] ?? null) && filled($row['url'] ?? null);
        }));

        SiteSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'about' => $data['about'] ?? [],
                'contact' => $data['contact'] ?? [],
                'footer' => $footer,
                'legal' => $data['legal'] ?? [],
            ],
        );

        SiteSettings::clearCache();

        return redirect()
            ->route('admin.site-settings.edit')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
