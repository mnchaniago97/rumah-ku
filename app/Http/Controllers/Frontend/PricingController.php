<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AgentApplication;
use App\Models\SubscriptionPlan;
use Illuminate\View\View;

class PricingController extends Controller
{
    public function show(string $type): View
    {
        $typeOptions = AgentApplication::typeOptions();
        $typeSlug = $type;
        $typeKey = AgentApplication::typeFromSlug($typeSlug);
        abort_unless($typeKey && array_key_exists($typeKey, $typeOptions), 404);

        $config = $this->typeConfig($typeKey);

        $plansFromAdmin = SubscriptionPlan::query()
            ->where('agent_type', $typeKey)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $plans = $plansFromAdmin->count()
            ? $plansFromAdmin->map(function (SubscriptionPlan $plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'subtitle' => $plan->subtitle,
                    'price' => $plan->price,
                    'period' => $plan->period_label ?? '',
                    'badge' => $plan->badge,
                    'highlight' => (bool)$plan->is_highlight,
                    'cta' => 'Pilih Paket',
                    'features' => is_array($plan->features) ? $plan->features : [],
                ];
            })->all()
            : $this->plansFallback($typeKey);

        return view('frontend.pages.pricing.show', [
            'title' => $config['page_title'],
            'type' => $typeSlug,
            'typeKey' => $typeKey,
            'typeLabel' => $typeOptions[$typeKey],
            'typeOptions' => $typeOptions,
            'config' => $config,
            'plans' => $plans,
            'comparison' => $this->comparison($typeKey, $plansFromAdmin),
            'faqs' => $this->faqs($typeKey),
        ]);
    }

    private function typeConfig(string $type): array
    {
        return match ($type) {
            AgentApplication::TYPE_PROPERTY_AGENT => [
                'page_title' => 'Agen Properti',
                'hero_title' => 'Jual Properti Cepat, Raih Keuntungan Maksimal',
                'hero_subtitle' => 'Pilih paket yang sesuai untuk memperluas jangkauan, mempercepat closing, dan membangun profil profesional.',
                'hero_gradient' => 'from-[#0B2B6B] via-[#0B2B6B] to-[#0E3A8A]',
                'accentBg' => 'bg-blue-700',
                'accentHover' => 'hover:bg-blue-800',
            ],
            AgentApplication::TYPE_IN_HOUSE_MARKETING => [
                'page_title' => 'In-House Marketing',
                'hero_title' => 'Kelola Iklan Proyek, Leads, dan Closing Lebih Cepat',
                'hero_subtitle' => 'Solusi untuk tim marketing in-house agar listing proyek rapi, leads tertata, dan performa terukur.',
                'hero_gradient' => 'from-[#0B2B6B] via-[#0B2B6B] to-[#1E40AF]',
                'accentBg' => 'bg-blue-700',
                'accentHover' => 'hover:bg-blue-800',
            ],
            AgentApplication::TYPE_PROPERTY_OWNER => [
                'page_title' => 'Pemilik Properti',
                'hero_title' => 'Pasang Iklan Jual & Sewakan Properti Pribadi Lebih Praktis',
                'hero_subtitle' => 'Pasang iklan properti pribadi dengan mudah, tampil menonjol, dan dapatkan calon pembeli/penyewa lebih cepat.',
                'hero_gradient' => 'from-[#7AA3E6] via-[#7AA3E6] to-[#F3C26B]',
                'accentBg' => 'bg-blue-700',
                'accentHover' => 'hover:bg-blue-800',
            ],
            AgentApplication::TYPE_DEVELOPER => [
                'page_title' => 'Developer',
                'hero_title' => 'Pasarkan Proyek Properti Anda Bersama Rumah123',
                'hero_subtitle' => 'Dapatkan eksposur terbaik untuk proyek Anda, dukungan campaign, dan reporting yang jelas.',
                'hero_gradient' => 'from-[#C59A33] via-[#C59A33] to-[#0B2B6B]',
                'accentBg' => 'bg-blue-700',
                'accentHover' => 'hover:bg-blue-800',
            ],
            default => [
                'page_title' => 'Price List',
                'hero_title' => 'Pilih Paket',
                'hero_subtitle' => '',
                'hero_gradient' => 'from-blue-900 via-blue-800 to-blue-700',
                'accentBg' => 'bg-blue-700',
                'accentHover' => 'hover:bg-blue-800',
            ],
        };
    }

    private function plansFallback(string $type): array
    {
        $common = [
            [
                'name' => 'Starter',
                'subtitle' => 'Mulai',
                'price' => 0,
                'period' => 'Gratis',
                'badge' => 'Mulai',
                'cta' => 'Pilih Paket',
                'features' => [
                    '1 listing aktif',
                    'Tampil di pencarian',
                    'Inquiry dasar',
                ],
            ],
            [
                'name' => 'Pro',
                'subtitle' => 'Populer',
                'price' => 250000,
                'period' => 'per bulan',
                'badge' => 'Populer',
                'highlight' => true,
                'cta' => 'Pilih Paket',
                'features' => [
                    '10 listing aktif',
                    'Boost di pencarian',
                    'Statistik performa',
                    'Support prioritas',
                ],
            ],
            [
                'name' => 'Business',
                'subtitle' => 'Maksimal',
                'price' => 650000,
                'period' => 'per bulan',
                'badge' => 'Maksimal',
                'cta' => 'Pilih Paket',
                'features' => [
                    '30 listing aktif',
                    'Boost + rekomendasi',
                    'Analytics lengkap',
                    'Badge profesional',
                ],
            ],
        ];

        return match ($type) {
            AgentApplication::TYPE_DEVELOPER => [
                [
                    'name' => 'Basic',
                    'price' => 1500000,
                    'period' => 'per bulan',
                    'badge' => 'Mulai',
                    'cta' => 'Konsultasi',
                    'features' => [
                        '1 proyek aktif',
                        'Landing proyek',
                        'Laporan bulanan',
                    ],
                ],
                [
                    'name' => 'Growth',
                    'price' => 3500000,
                    'period' => 'per bulan',
                    'badge' => 'Populer',
                    'highlight' => true,
                    'cta' => 'Konsultasi',
                    'features' => [
                        '3 proyek aktif',
                        'Campaign support',
                        'Leads management',
                        'Laporan mingguan',
                    ],
                ],
                [
                    'name' => 'Custom',
                    'price' => null,
                    'period' => 'custom',
                    'badge' => 'Custom',
                    'cta' => 'Hubungi Kami',
                    'features' => [
                        'Multi proyek',
                        'Integrasi & SLA',
                        'Dedicated support',
                    ],
                ],
            ],
            AgentApplication::TYPE_PROPERTY_OWNER => [
                $common[0],
                [
                    'name' => 'Highlight',
                    'price' => 99000,
                    'period' => 'per iklan',
                    'badge' => 'Populer',
                    'highlight' => true,
                    'cta' => 'Iklankan Sekarang',
                    'features' => [
                        'Highlight iklan',
                        'Prioritas di listing',
                        'Statistik performa',
                    ],
                ],
                [
                    'name' => 'Premium',
                    'price' => 199000,
                    'period' => 'per iklan',
                    'badge' => 'Maksimal',
                    'cta' => 'Iklankan Sekarang',
                    'features' => [
                        'Premium badge',
                        'Push rekomendasi',
                        'Support prioritas',
                    ],
                ],
            ],
            default => $common,
        };
    }

    private function comparison(string $type, $plansFromAdmin): array
    {
        $rows = [
            ['label' => 'Listing aktif', 'key' => 'listings'],
            ['label' => 'Boost di pencarian', 'key' => 'boost'],
            ['label' => 'Statistik performa', 'key' => 'stats'],
            ['label' => 'Badge profesional', 'key' => 'badge'],
            ['label' => 'Support prioritas', 'key' => 'support'],
        ];

        if ($plansFromAdmin instanceof \Illuminate\Support\Collection && $plansFromAdmin->count()) {
            $cols = $plansFromAdmin->map(function (SubscriptionPlan $plan) {
                $access = is_array($plan->access) ? $plan->access : [];
                return [
                    'label' => $plan->name,
                    'values' => [
                        'listings' => $access['listings'] ?? '-',
                        'boost' => (bool)($access['boost'] ?? false),
                        'stats' => (bool)($access['stats'] ?? false),
                        'badge' => (bool)($access['badge'] ?? false),
                        'support' => (bool)($access['support'] ?? false),
                    ],
                ];
            })->all();

            return compact('rows', 'cols');
        }

        $cols = match ($type) {
            AgentApplication::TYPE_DEVELOPER => [
                ['label' => 'Basic', 'values' => ['listings' => '1 proyek', 'boost' => true, 'stats' => true, 'badge' => false, 'support' => false]],
                ['label' => 'Growth', 'values' => ['listings' => '3 proyek', 'boost' => true, 'stats' => true, 'badge' => true, 'support' => true]],
                ['label' => 'Custom', 'values' => ['listings' => 'Custom', 'boost' => true, 'stats' => true, 'badge' => true, 'support' => true]],
            ],
            AgentApplication::TYPE_PROPERTY_OWNER => [
                ['label' => 'Starter', 'values' => ['listings' => '1', 'boost' => false, 'stats' => true, 'badge' => false, 'support' => false]],
                ['label' => 'Highlight', 'values' => ['listings' => '1', 'boost' => true, 'stats' => true, 'badge' => true, 'support' => false]],
                ['label' => 'Premium', 'values' => ['listings' => '1', 'boost' => true, 'stats' => true, 'badge' => true, 'support' => true]],
            ],
            default => [
                ['label' => 'Starter', 'values' => ['listings' => '1', 'boost' => false, 'stats' => false, 'badge' => false, 'support' => false]],
                ['label' => 'Pro', 'values' => ['listings' => '10', 'boost' => true, 'stats' => true, 'badge' => false, 'support' => true]],
                ['label' => 'Business', 'values' => ['listings' => '30', 'boost' => true, 'stats' => true, 'badge' => true, 'support' => true]],
            ],
        };

        return compact('rows', 'cols');
    }

    private function faqs(string $type): array
    {
        $common = [
            ['q' => 'Apakah langsung dapat akses dashboard?', 'a' => 'Belum. Setelah Anda kirim pendaftaran, admin akan meninjau dan menyetujui terlebih dahulu.'],
            ['q' => 'Apakah fitur dashboard sama untuk semua tipe?', 'a' => 'Tidak. Admin menentukan fitur berdasarkan tipe pendaftaran dan kebutuhan.'],
            ['q' => 'Jika paket sudah dipilih, apakah bisa upgrade?', 'a' => 'Bisa. Anda dapat mengajukan perubahan paket/akses dan admin akan menyesuaikan.'],
        ];

        return match ($type) {
            AgentApplication::TYPE_DEVELOPER => array_merge($common, [
                ['q' => 'Apakah bisa request paket custom?', 'a' => 'Bisa. Pilih paket Custom lalu hubungi kami untuk kebutuhan campaign dan integrasi.'],
            ]),
            default => $common,
        };
    }
}
