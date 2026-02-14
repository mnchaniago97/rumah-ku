<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettings
{
    private const CACHE_KEY = 'site_settings.v2';

    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public static function get(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            $row = SiteSetting::query()->first();

            $data = [
                'about' => $row?->about ?? [],
                'contact' => $row?->contact ?? [],
                'footer' => $row?->footer ?? [],
                'legal' => $row?->legal ?? [],
            ];

            return self::mergeDefaults($data);
        });
    }

    public static function about(): array
    {
        return self::get()['about'] ?? [];
    }

    public static function contact(): array
    {
        return self::get()['contact'] ?? [];
    }

    public static function footer(): array
    {
        return self::get()['footer'] ?? [];
    }

    public static function legal(): array
    {
        return self::get()['legal'] ?? [];
    }

    private static function mergeDefaults(array $data): array
    {
        $defaults = [
            'about' => [
                'title' => 'Tentang Rumah IO',
                'subtitle' => 'Platform properti terpercaya Indonesia',
                'heading' => 'Tentang Kami',
                'content' => "Rumah IO adalah platform properti terpercaya yang berkomitmen untuk membantu Anda menemukan rumah impian dengan mudah, aman, dan transparan. Kami menyediakan berbagai pilihan properti dari seluruh Indonesia, mulai dari rumah tinggal, apartemen, villa, ruko, hingga tanah.\n\nDidukung oleh tim profesional yang berpengalaman di bidang properti, kami berkomitmen untuk memberikan pelayanan terbaik bagi setiap klien kami. Baik Anda pembeli, penjual, maupun penyewa properti, Rumah IO siap membantu kebutuhan properti Anda.\n\nKami percaya bahwa memiliki rumah adalah impian setiap orang. Oleh karena itu, kami terus berinovasi untuk memberikan pengalaman pencarian properti yang lebih mudah, cepat, dan terpercaya.",
            ],
            'contact' => [
                'title' => 'Hubungi Kami',
                'subtitle' => 'Punya pertanyaan atau butuh bantuan? Silakan hubungi kami',
                'address' => 'Jl. Jendral Sudirman No. 123, Jakarta Selatan, DKI Jakarta 12190',
                'phone' => '021-1234-5678',
                'whatsapp' => '+62 812-3456-7890',
                'whatsapp_link' => 'https://wa.me/6281234567890',
                'email' => 'info@rumah.io',
                'hours' => 'Senin - Sabtu: 08:00 - 18:00 WIB',
                'notes' => 'Tutup hari Minggu dan hari libur nasional',
                'maps_embed_html' => '',
            ],
            'footer' => [
                'brand' => 'Rumah IO',
                'description' => 'Rumah IO adalah platform properti terpercaya yang membantu Anda menemukan rumah impian dengan mudah dan aman. Kami menyediakan berbagai pilihan properti dari seluruh Indonesia.',
                'socials' => [
                    'facebook' => '',
                    'instagram' => '',
                    'twitter' => '',
                    'youtube' => '',
                    'linkedin' => '',
                    'whatsapp' => '',
                ],
                'quick_links' => [
                    ['label' => 'Properti', 'url' => '/properties'],
                    ['label' => 'Proyek', 'url' => '/perumahan-baru'],
                    ['label' => 'Agen', 'url' => '/agents'],
                    ['label' => 'Artikel', 'url' => '/articles'],
                    ['label' => 'Tentang Kami', 'url' => '/about'],
                    ['label' => 'Kontak', 'url' => '/contact'],
                ],
                'contact' => [
                    'address' => 'Jl. Sudirman No. 123, Jakarta Pusat 10220',
                    'phone' => '+62 21 1234 5678',
                    'email' => 'info@rumah.io',
                    'whatsapp' => '+62 812 3456 7890',
                ],
                'copyright' => '© ' . date('Y') . ' Rumah IO. All rights reserved.',
                'legal_links' => [
                    ['label' => 'Kebijakan Privasi', 'url' => '/kebijakan-privasi'],
                    ['label' => 'Syarat Penggunaan', 'url' => '/syarat-penggunaan'],
                    ['label' => 'Syarat Penggunaan Agen', 'url' => '/syarat-penggunaan-agen'],
                    ['label' => 'Community Guideline', 'url' => '/community-guideline'],
                ],
            ],
            'legal' => [
                'privacy_policy' => [
                    'title' => 'Kebijakan Privasi',
                    'content' => "Kami menghargai privasi Anda. Halaman ini menjelaskan jenis data yang kami kumpulkan, bagaimana data digunakan, serta pilihan Anda terkait data tersebut.\n\n1. Data yang kami kumpulkan\n- Data akun (nama, email, nomor telepon)\n- Data listing/properti yang Anda unggah\n- Data penggunaan (log, perangkat, cookie)\n\n2. Cara kami menggunakan data\n- Menyediakan layanan dan fitur platform\n- Verifikasi akun dan keamanan\n- Peningkatan kualitas layanan\n\n3. Berbagi data\nKami tidak menjual data pribadi Anda. Data hanya dibagikan jika diperlukan (misalnya penyedia layanan, kewajiban hukum).\n\n4. Keamanan\nKami menerapkan langkah keamanan yang wajar untuk melindungi data.\n\n5. Kontak\nJika ada pertanyaan terkait privasi, silakan hubungi kami melalui halaman Kontak.",
                ],
                'terms' => [
                    'title' => 'Syarat Penggunaan',
                    'content' => "Dengan menggunakan Rumah IO, Anda menyetujui syarat penggunaan berikut.\n\n1. Akun\nAnda bertanggung jawab atas keamanan akun dan aktivitas di dalamnya.\n\n2. Konten\nDilarang mengunggah konten yang melanggar hukum, menyesatkan, atau melanggar hak pihak lain.\n\n3. Listing\nInformasi listing harus akurat dan dapat dipertanggungjawabkan.\n\n4. Pembatasan tanggung jawab\nRumah IO berupaya menyediakan informasi sebaik mungkin, namun tidak bertanggung jawab atas transaksi di luar platform.\n\n5. Perubahan\nSyarat ini dapat diperbarui sewaktu-waktu.",
                ],
                'agent_terms' => [
                    'title' => 'Syarat Penggunaan Agen',
                    'content' => "Syarat ini berlaku khusus untuk pengguna yang mendaftar sebagai Agen.\n\n1. Verifikasi\nStatus 'Verified' diberikan oleh Admin setelah verifikasi.\n\n2. Kepatuhan\nAgen wajib mematuhi ketentuan publikasi listing, etika komunikasi, dan keakuratan informasi.\n\n3. Penyalahgunaan\nAkun agen dapat dibatasi/ditangguhkan jika terdapat pelanggaran atau laporan valid.\n\n4. Paket & fitur\nAkses fitur mengikuti paket langganan yang disetujui Admin.",
                ],
                'community_guideline' => [
                    'title' => 'Community Guideline',
                    'content' => "Agar komunitas tetap aman dan bermanfaat, mohon patuhi panduan berikut:\n\nDo / Boleh dilakukan:\n- Berdiskusi dengan sopan dan fokus pada solusi\n- Berbagi pengalaman/pengetahuan yang relevan\n- Menjaga privasi data pribadi\n\nDon't / Dilarang:\n- Spam, promosi agresif, atau penipuan\n- Ujaran kebencian, bullying, intimidasi\n- Konten ilegal atau melanggar hak cipta\n\nPelanggaran dapat menyebabkan konten dihapus atau akun dibatasi.",
                ],
            ],
        ];

        $merged = [
            'about' => array_replace_recursive($defaults['about'], $data['about'] ?? []),
            'contact' => array_replace_recursive($defaults['contact'], $data['contact'] ?? []),
            'footer' => array_replace_recursive($defaults['footer'], $data['footer'] ?? []),
            'legal' => array_replace_recursive($defaults['legal'], $data['legal'] ?? []),
        ];

        // Ensure footer legal links contain required pages (don't override custom URLs unless blank or '#').
        $requiredLegalLinks = $defaults['footer']['legal_links'];
        $existingLegalLinks = $merged['footer']['legal_links'] ?? [];
        $outLinks = [];

        foreach ($requiredLegalLinks as $required) {
            $label = (string) ($required['label'] ?? '');
            $found = null;
            foreach ($existingLegalLinks as $row) {
                if (strcasecmp((string) ($row['label'] ?? ''), $label) === 0) {
                    $found = $row;
                    break;
                }
            }

            $url = $found['url'] ?? null;
            if (!filled($url) || $url === '#') {
                $url = $required['url'] ?? '#';
            }

            $outLinks[] = ['label' => $label, 'url' => $url];
        }

        // Append any other custom legal links (excluding duplicates).
        foreach ($existingLegalLinks as $row) {
            $label = (string) ($row['label'] ?? '');
            if ($label === '') continue;

            $isDuplicate = false;
            foreach ($outLinks as $out) {
                if (strcasecmp((string) ($out['label'] ?? ''), $label) === 0) {
                    $isDuplicate = true;
                    break;
                }
            }
            if ($isDuplicate) continue;

            if (filled($row['url'] ?? null) && ($row['url'] ?? null) !== '#') {
                $outLinks[] = ['label' => $label, 'url' => $row['url']];
            }
        }

        $merged['footer']['legal_links'] = $outLinks;

        return $merged;
    }
}
