@extends('frontend.layouts.app')

@section('content')
    @php
        $reasons = [
            ['title' => 'Turunkan cicilan', 'desc' => 'Atur ulang tenor/struktur kredit agar cicilan lebih ringan.'],
            ['title' => 'Bunga lebih kompetitif', 'desc' => 'Cari skema bunga yang lebih sesuai kondisi sekarang.'],
            ['title' => 'Tambah dana renovasi', 'desc' => 'Untuk kebutuhan tertentu, refinancing bisa bantu cashflow (tergantung bank).'],
            ['title' => 'Rapikan arus kas', 'desc' => 'Konsolidasi dan pengaturan kembali biaya bulanan.'],
        ];

        $steps = [
            ['01', 'Konsultasi kebutuhan', 'Tentukan tujuan refinancing dan target cicilan.'],
            ['02', 'Cek dokumen', 'Siapkan identitas, penghasilan, dan dokumen properti.'],
            ['03', 'Proses bank', 'SLIK, verifikasi, appraisal, dan penawaran.'],
            ['04', 'Akad & pencairan', 'Tanda tangan akad dan pencairan sesuai ketentuan.'],
        ];

        $faqs = [
            [
                'q' => 'Apa beda refinancing dan take over?',
                'a' => 'Refinancing fokus pada pengaturan ulang pembiayaan (bisa di bank yang sama atau berbeda). Take over umumnya memindahkan kredit dari bank lama ke bank baru.',
            ],
            [
                'q' => 'Apakah refinancing pasti menurunkan cicilan?',
                'a' => 'Tidak selalu. Hasilnya tergantung penawaran bunga, tenor, biaya, dan profil pemohon. Sebaiknya hitung total biaya dan simulasi cicilan.',
            ],
            [
                'q' => 'Biaya apa saja yang biasanya muncul?',
                'a' => 'Umumnya provisi, administrasi, appraisal, notaris, dan biaya lain sesuai kebijakan bank.',
            ],
        ];
    @endphp

    <div class="bg-gray-50">
        <section class="bg-gradient-to-br from-slate-900 to-indigo-700 py-14 text-white">
            <div class="max-w-[1200px] mx-auto px-4">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-semibold">KPR</p>
                        <h1 class="mt-1 text-3xl md:text-4xl font-extrabold">Refinancing</h1>
                        <p class="mt-3 max-w-2xl text-white/90">
                            Panduan ringkas untuk atur ulang cicilan dan skema bunga sesuai kebutuhanmu.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('kpr') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-5 py-3 text-sm font-semibold text-white hover:bg-white/15">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="button" data-open-property-inquiry
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-indigo-700 hover:bg-white/90">
                            <i class="fa-brands fa-whatsapp"></i>
                            Konsultasi
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-[1200px] mx-auto px-4 py-12 space-y-10">
            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                <h2 class="text-2xl font-extrabold text-gray-900">Kenapa Refinancing?</h2>
                <p class="mt-2 text-sm text-gray-600">Beberapa alasan paling umum.</p>
                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    @foreach ($reasons as $r)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                            <p class="font-bold text-gray-900">{{ $r['title'] }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $r['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('calculator') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-700 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-800">
                        <i class="fa-solid fa-calculator"></i>
                        Simulasi Cicilan
                    </a>
                    <a href="{{ route('kpr.dokumen') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        <i class="fa-solid fa-file-lines"></i>
                        Checklist Dokumen
                    </a>
                </div>
            </section>

            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                <h2 class="text-2xl font-extrabold text-gray-900">Tahapan Refinancing</h2>
                <div class="mt-6 grid gap-4 md:grid-cols-4">
                    @foreach ($steps as $s)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                            <p class="text-xs font-bold text-indigo-700">{{ $s[0] }}</p>
                            <p class="mt-2 font-bold text-gray-900">{{ $s[1] }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $s[2] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm" x-data="{ open: 0 }">
                <h2 class="text-2xl font-extrabold text-gray-900">FAQ</h2>
                <div class="mt-6 divide-y divide-gray-100 rounded-2xl border border-gray-100">
                    @foreach ($faqs as $idx => $item)
                        <div class="p-4">
                            <button type="button" class="flex w-full items-center justify-between gap-4 text-left"
                                @click="open = open === {{ $idx + 1 }} ? 0 : {{ $idx + 1 }}">
                                <span class="font-semibold text-gray-900">{{ $item['q'] }}</span>
                                <i class="fa-solid" :class="open === {{ $idx + 1 }} ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                            <div x-show="open === {{ $idx + 1 }}" x-transition x-cloak>
                                <p class="mt-3 text-sm text-gray-600">{{ $item['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-2xl bg-indigo-700 p-8 text-white">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold">Mau dibantu hitung opsi refinancing?</h3>
                        <p class="mt-1 text-sm text-white/85">Klik konsultasi, tim kami bantu cek skema terbaik.</p>
                    </div>
                    <button type="button" data-open-property-inquiry
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-indigo-700 hover:bg-white/90">
                        <i class="fa-brands fa-whatsapp"></i>
                        Konsultasi Sekarang
                    </button>
                </div>
            </section>
        </div>
    </div>
@endsection

