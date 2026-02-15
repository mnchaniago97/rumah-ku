<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\View\View;

class CompanyPartnerController extends Controller
{
    public function index(): View
    {
        $partners = Partner::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->groupBy('type');

        $bankPartners = ($partners[Partner::TYPE_BANK] ?? collect())
            ->filter(fn (Partner $p) => $p->is_kpr)
            ->values();

        return view('frontend.pages.company.partners', [
            'title' => 'Partner - Rumah IO',
            'developerPartners' => ($partners[Partner::TYPE_DEVELOPER] ?? collect())->values(),
            'agentPartners' => ($partners[Partner::TYPE_AGENT] ?? collect())->values(),
            'bankPartners' => $bankPartners,
        ]);
    }
}

