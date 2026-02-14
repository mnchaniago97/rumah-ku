@extends('frontend.layouts.app')

@section('content')
    @php
        $requirements = [
            'WNI dan memenuhi syarat usia sesuai ketentuan bank/program.',
            'Memiliki penghasilan tetap/usahanya bisa diverifikasi.',
            'Belum memiliki rumah (untuk program tertentu, mengikuti aturan terbaru).',
            'Memiliki dokumen identitas dan dokumen penghasilan yang lengkap.',
        ];

        $documents = [
            'KTP, KK, NPWP (jika ada)',
            'Slip gaji / surat keterangan kerja / dokumen usaha',
            'Rekening koran / mutasi 3–6 bulan terakhir',
            'Dokumen properti (brosur/booking, SHM/SHGB bila rumah second)',
        ];

        $faqs = [
            [
                'q' => 'Apa itu KPR subsidi?',
                'a' => 'KPR subsidi adalah program pembiayaan rumah dengan dukungan pemerintah (atau program bank tertentu) yang biasanya menawarkan bunga/angsuran lebih ringan, dengan syarat dan kuota tertentu.',
            ],
            [
                'q' => 'Siapa yang bisa mengajukan KPR subsidi?',
                'a' => 'Umumnya MBR (masyarakat berpenghasilan rendah) sesuai batas penghasilan dan ketentuan program. Detailnya mengikuti aturan terbaru dan kebijakan bank.',
            ],
            [
                'q' => 'Apakah bisa mengajukan jika pernah kredit lain?',
                'a' => 'Tergantung hasil SLIK OJK dan ketentuan program. Kolektibilitas yang baik biasanya membantu proses persetujuan.',
            ],
        ];
    @endphp

    <div class="bg-gray-50">
        <section class="bg-gradient-to-br from-emerald-700 to-emerald-500 py-14 text-white">
            <div class="max-w-[1200px] mx-auto px-4">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-semibold">KPR</p>
                        <h1 class="mt-1 text-3xl md:text-4xl font-extrabold">KPR Subsidi</h1>
                        <p class="mt-3 max-w-2xl text-white/90">
                            Panduan ringkas untuk memahami syarat umum, dokumen yang perlu disiapkan, dan langkah pengajuan.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('kpr') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-5 py-3 text-sm font-semibold text-white hover:bg-white/15">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="button" data-open-property-inquiry
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-emerald-700 hover:bg-white/90">
                            <i class="fa-brands fa-whatsapp"></i>
                            Konsultasi
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-[1200px] mx-auto px-4 py-12 space-y-10">
            <section class="grid gap-6 lg:grid-cols-2">
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                    <h2 class="text-2xl font-extrabold text-gray-900">Syarat Umum</h2>
                    <p class="mt-2 text-sm text-gray-600">Syarat bisa berbeda per program/bank, berikut gambaran umumnya.</p>
                    <ul class="mt-6 space-y-3 text-sm text-gray-700">
                        @foreach ($requirements as $r)
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check mt-0.5 text-emerald-600"></i>
                                <span>{{ $r }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                    <h2 class="text-2xl font-extrabold text-gray-900">Dokumen yang Disiapkan</h2>
                    <p class="mt-2 text-sm text-gray-600">Biar proses cepat, siapkan dokumen berikut sejak awal.</p>
                    <ul class="mt-6 space-y-3 text-sm text-gray-700">
                        @foreach ($documents as $d)
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-file-lines mt-0.5 text-emerald-600"></i>
                                <span>{{ $d }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-6">
                        <a href="{{ route('kpr.dokumen') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                            Lihat checklist dokumen lengkap →
                        </a>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                <h2 class="text-2xl font-extrabold text-gray-900">Langkah Pengajuan</h2>
                <div class="mt-6 grid gap-4 md:grid-cols-4">
                    @foreach ([
                        ['01', 'Pilih unit', 'Tentukan rumah dan siapkan data dasarnya.'],
                        ['02', 'Simulasi', 'Hitung estimasi cicilan sesuai DP & tenor.'],
                        ['03', 'Ajukan ke bank', 'Verifikasi dokumen, SLIK, dan appraisal.'],
                        ['04', 'Akad', 'Tanda tangan akad dan pencairan.'],
                    ] as $s)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                            <p class="text-xs font-bold text-emerald-700">{{ $s[0] }}</p>
                            <p class="mt-2 font-bold text-gray-900">{{ $s[1] }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $s[2] }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('calculator') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">
                        <i class="fa-solid fa-calculator"></i>
                        Simulasi Cicilan
                    </a>
                    <a href="{{ route('eligibility') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        <i class="fa-solid fa-circle-check"></i>
                        Cek Kelayakan
                    </a>
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

            <section class="rounded-2xl bg-emerald-700 p-8 text-white">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold">Mau dibantu proses KPR subsidi?</h3>
                        <p class="mt-1 text-sm text-white/85">Klik tombol konsultasi, tim kami bantu cek opsi terbaik.</p>
                    </div>
                    <button type="button" data-open-property-inquiry
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-emerald-700 hover:bg-white/90">
                        <i class="fa-brands fa-whatsapp"></i>
                        Konsultasi Sekarang
                    </button>
                </div>
            </section>
        </div>
    </div>
@endsection

