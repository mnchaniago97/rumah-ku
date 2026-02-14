<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalController extends Controller
{
    public function show(Request $request, string $page): View
    {
        $page = strtolower(trim($page));

        $map = [
            'kebijakan-privasi' => 'privacy_policy',
            'syarat-penggunaan' => 'terms',
            'syarat-penggunaan-agen' => 'agent_terms',
            'community-guideline' => 'community_guideline',
        ];

        abort_unless(isset($map[$page]), 404);

        $key = $map[$page];
        $legal = SiteSettings::legal();
        $data = $legal[$key] ?? [];

        $pages = [
            'privacy_policy' => ['slug' => 'kebijakan-privasi', 'label' => 'Kebijakan Privasi'],
            'terms' => ['slug' => 'syarat-penggunaan', 'label' => 'Syarat Penggunaan'],
            'agent_terms' => ['slug' => 'syarat-penggunaan-agen', 'label' => 'Syarat Penggunaan Agen'],
            'community_guideline' => ['slug' => 'community-guideline', 'label' => 'Community Guideline'],
        ];

        return view('frontend.pages.legal.show', [
            'title' => $data['title'] ?? ($pages[$key]['label'] ?? 'Halaman'),
            'active' => $key,
            'pageSlug' => $page,
            'pages' => $pages,
            'content' => $data['content'] ?? '',
        ]);
    }
}

