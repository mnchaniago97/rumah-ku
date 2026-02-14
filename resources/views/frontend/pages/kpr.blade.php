@extends('frontend.layouts.app')

@section('content')
    @php
        $banks = [
            [
                'name' => 'Bank BCA',
                'tag' => 'Fix & Floating',
                'desc' => 'Pilihan bunga kompetitif dengan tenor fleksibel.',
                'color' => 'bg-blue-700',
                'icon' => 'fa-solid fa-building-columns',
            ],
            [
                'name' => 'Bank Mandiri',
                'tag' => 'KPR Cepat',
                'desc' => 'Cocok untuk proses cepat dengan dokumen siap.',
                'color' => 'bg-indigo-700',
                'icon' => 'fa-solid fa-bolt',
            ],
            [
                'name' => 'BRI',
                'tag' => 'KPR Subsidi',
                'desc' => 'Alternatif program subsidi & komersial.',
                'color' => 'bg-slate-800',
                'icon' => 'fa-solid fa-hand-holding-dollar',
            ],
        ];

        $features = [
            ['title' => 'KPR Baru', 'icon' => 'fa-solid fa-key', 'desc' => 'Pembelian rumah baru/second'],
            ['title' => 'KPR Subsidi', 'icon' => 'fa-solid fa-house-circle-check', 'desc' => 'Program FLPP & sejenis'],
            ['title' => 'Take Over', 'icon' => 'fa-solid fa-right-left', 'desc' => 'Alih kredit dari bank lain'],
            ['title' => 'Refinancing', 'icon' => 'fa-solid fa-rotate', 'desc' => 'Atur ulang cicilan & bunga'],
            ['title' => 'Dokumen', 'icon' => 'fa-solid fa-file-lines', 'desc' => 'Checklist persyaratan jelas'],
            ['title' => 'Konsultasi', 'icon' => 'fa-solid fa-headset', 'desc' => 'Dibantu sampai pengajuan'],
        ];

        $glossary = [
            ['term' => 'Agunan', 'desc' => 'Aset yang dijaminkan ke bank sebagai pengaman kredit.'],
            ['term' => 'AJB', 'desc' => 'Akta Jual Beli, dokumen pengalihan hak atas tanah/bangunan.'],
            ['term' => 'Appraisal', 'desc' => 'Penilaian nilai properti oleh pihak penilai (bank).'],
            ['term' => 'BI Checking/SLIK OJK', 'desc' => 'Riwayat kredit dan kolektibilitas debitur.'],
            ['term' => 'DP (Down Payment)', 'desc' => 'Uang muka yang dibayar di awal pembelian properti.'],
            ['term' => 'Floating Rate', 'desc' => 'Bunga yang mengikuti suku bunga pasar setelah periode fix.'],
            ['term' => 'Fix Rate', 'desc' => 'Bunga tetap dalam periode tertentu.'],
            ['term' => 'Grace Period', 'desc' => 'Masa tunda pembayaran pokok (tergantung program).'],
            ['term' => 'Tenor', 'desc' => 'Jangka waktu pinjaman (mis. 10–25 tahun).'],
        ];

        $faqs = [
            [
                'q' => 'Apa itu KPR?',
                'a' => 'Kredit Pemilikan Rumah (KPR) adalah fasilitas pembiayaan dari bank untuk membeli rumah dengan skema cicilan.',
            ],
            [
                'q' => 'Berapa minimal DP untuk KPR?',
                'a' => 'Tergantung kebijakan bank dan jenis properti. Umumnya mulai dari 10%–30% dari harga properti.',
            ],
            [
                'q' => 'Dokumen apa saja yang biasanya dibutuhkan?',
                'a' => 'Umumnya KTP, KK, NPWP, slip gaji/rek. koran, surat keterangan kerja/usaha, dan dokumen properti. Detail bisa berbeda tiap bank.',
            ],
            [
                'q' => 'Berapa lama proses pengajuan KPR?',
                'a' => 'Rata-rata 7–21 hari kerja, bergantung kelengkapan dokumen, appraisal, dan verifikasi bank.',
            ],
            [
                'q' => 'Apa bedanya fix dan floating rate?',
                'a' => 'Fix rate bunga tetap pada periode tertentu, sedangkan floating rate dapat naik/turun mengikuti pasar setelah periode fix berakhir.',
            ],
            [
                'q' => 'Bisa simulasi cicilan dulu?',
                'a' => 'Bisa. Gunakan fitur Simulasi KPR untuk menghitung estimasi cicilan berdasarkan harga, DP, tenor, dan suku bunga.',
            ],
        ];
    @endphp

    <div class="bg-gray-50">
        {{-- Hero --}}
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-800 via-blue-700 to-indigo-700 py-14 text-white">
            <div class="absolute inset-0 opacity-20">
                <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/20 blur-2xl"></div>
                <div class="pointer-events-none absolute -left-24 -bottom-24 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
            </div>

            <div class="max-w-[1200px] mx-auto px-4 relative">
                <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                    <div>
                        <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold tracking-wide">
                            <i class="fa-solid fa-circle-check"></i>
                            Panduan KPR
                        </p>
                        <h1 class="mt-4 text-3xl md:text-4xl font-extrabold leading-tight">
                            KPR dari Rumah IO, solusi punya rumah jadi lebih mudah.
                        </h1>
                        <p class="mt-3 max-w-xl text-white/85">
                            Mulai dari memahami istilah, menyiapkan dokumen, memilih program bank, sampai pengajuan. Semua bisa dibantu dari awal.
                        </p>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('calculator') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-800 hover:bg-white/90">
                                <i class="fa-solid fa-calculator"></i>
                                Simulasi Cicilan
                            </a>
                            <button type="button" data-open-property-inquiry
                                class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/30 bg-white/10 px-5 py-3 text-sm font-semibold text-white hover:bg-white/15">
                                <i class="fa-brands fa-whatsapp"></i>
                                Konsultasi KPR
                            </button>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-5 ring-1 ring-white/15">
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <a href="{{ route('kpr.simulasi') }}"
                                class="group rounded-xl bg-white/10 p-4 transition hover:bg-white/15">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                                    <i class="fa-solid fa-key"></i>
                                </div>
                                <p class="mt-3 text-sm font-semibold">KPR Baru</p>
                                <p class="mt-1 text-xs text-white/75">Pembelian rumah baru/second</p>
                            </a>

                            <a href="{{ route('kpr.subsidi') }}"
                                class="group rounded-xl bg-white/10 p-4 transition hover:bg-white/15">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                                    <i class="fa-solid fa-house-circle-check"></i>
                                </div>
                                <p class="mt-3 text-sm font-semibold">KPR Subsidi</p>
                                <p class="mt-1 text-xs text-white/75">Program FLPP &amp; sejenis</p>
                            </a>

                            <a href="{{ route('kpr.pindah') }}"
                                class="group rounded-xl bg-white/10 p-4 transition hover:bg-white/15">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                                    <i class="fa-solid fa-right-left"></i>
                                </div>
                                <p class="mt-3 text-sm font-semibold">Take Over</p>
                                <p class="mt-1 text-xs text-white/75">Alih kredit dari bank lain</p>
                            </a>

                            <a href="{{ route('kpr.refinancing') }}"
                                class="group rounded-xl bg-white/10 p-4 transition hover:bg-white/15">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                                    <i class="fa-solid fa-rotate"></i>
                                </div>
                                <p class="mt-3 text-sm font-semibold">Refinancing</p>
                                <p class="mt-1 text-xs text-white/75">Atur ulang cicilan &amp; bunga</p>
                            </a>

                            <a href="{{ route('kpr.dokumen') }}"
                                class="group rounded-xl bg-white/10 p-4 transition hover:bg-white/15">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>
                                <p class="mt-3 text-sm font-semibold">Dokumen</p>
                                <p class="mt-1 text-xs text-white/75">Checklist persyaratan jelas</p>
                            </a>

                            <button type="button" data-open-property-inquiry
                                class="group rounded-xl bg-white/10 p-4 text-left transition hover:bg-white/15">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <p class="mt-3 text-sm font-semibold">Konsultasi</p>
                                <p class="mt-1 text-xs text-white/75">Dibantu sampai pengajuan</p>
                            </button>
                        </div>
                        <p class="mt-4 text-xs text-white/70">
                            Catatan: Informasi program dapat berubah sesuai kebijakan bank.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-[1200px] mx-auto px-4 py-12 space-y-12">
            {{-- Rekomendasi bank/program --}}
            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-900">Rekomendasi Program KPR</h2>
                        <p class="mt-1 text-sm text-gray-600">Mulai dari program populer, pilih yang paling cocok untuk kebutuhanmu.</p>
                    </div>
                    <a href="{{ route('calculator') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">
                        Cek Simulasi KPR →
                    </a>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-3">
                    @foreach ($banks as $b)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-xl {{ $b['color'] }} text-white">
                                        <i class="{{ $b['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $b['name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $b['tag'] }}</p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-blue-50 px-2 py-1 text-[11px] font-semibold text-blue-700">Rekomendasi</span>
                            </div>
                            <p class="mt-4 text-sm text-gray-600">{{ $b['desc'] }}</p>
                            <div class="mt-5 flex gap-2">
                                <button type="button" data-open-property-inquiry
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                                    <i class="fa-solid fa-message"></i>
                                    Tanya Program
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- CTA band --}}
            <section class="rounded-2xl bg-amber-100/70 p-6 md:p-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Masih bingung pilih program KPR?</h3>
                        <p class="mt-1 text-sm text-gray-700">Ceritakan kebutuhanmu, biar kami bantu rekomendasikan opsi terbaik.</p>
                    </div>
                    <button type="button" data-open-property-inquiry
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                        <i class="fa-brands fa-whatsapp"></i>
                        Bantu Saya Dapatkan KPR
                    </button>
                </div>
            </section>

            {{-- Istilah KPR --}}
            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm"
                x-data="{
                    q: '',
                    terms: @js($glossary),
                    get filtered() {
                        const s = (this.q || '').toLowerCase().trim();
                        if (!s) return this.terms;
                        return this.terms.filter(t => (t.term + ' ' + t.desc).toLowerCase().includes(s));
                    }
                }">
                <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-900">Istilah KPR</h2>
                        <p class="mt-1 text-sm text-gray-600">Ringkas, mudah dipahami, dan sering muncul saat pengajuan.</p>
                    </div>
                    <div class="w-full md:w-96">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Cari istilah (contoh: DP, fix rate)"
                                x-model="q"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-10 pr-3 text-sm text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-200">
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <template x-for="item in filtered" :key="item.term">
                        <div class="rounded-xl border border-gray-100 p-4">
                            <p class="font-bold text-gray-900" x-text="item.term"></p>
                            <p class="mt-1 text-sm text-gray-600" x-text="item.desc"></p>
                        </div>
                    </template>
                </div>

                <div class="mt-6 text-sm text-gray-600">
                    Ingin hitung cicilan? <a href="{{ route('calculator') }}" class="font-semibold text-blue-700 hover:text-blue-800">Buka Simulasi KPR</a>.
                </div>
            </section>

            {{-- Tahapan --}}
            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                <h2 class="text-2xl font-extrabold text-gray-900">Tahapan KPR, dari Pengajuan hingga Diterima</h2>
                <p class="mt-1 text-sm text-gray-600">Gambaran umum proses (tiap bank bisa sedikit berbeda).</p>

                <div class="mt-6 grid gap-4 md:grid-cols-4">
                    @foreach ([
                        ['01', 'Konsultasi & simulasi', 'Tentukan harga, DP, tenor, dan estimasi cicilan.'],
                        ['02', 'Siapkan dokumen', 'Lengkapi data diri, income, dan dokumen properti.'],
                        ['03', 'Proses bank', 'Verifikasi, SLIK, dan appraisal properti.'],
                        ['04', 'Akad & pencairan', 'Tanda tangan akad, lalu pencairan sesuai proses.'],
                    ] as $step)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                            <p class="text-xs font-bold text-blue-700">{{ $step[0] }}</p>
                            <p class="mt-2 font-bold text-gray-900">{{ $step[1] }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $step[2] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- FAQ --}}
            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm" x-data="{ open: 0 }">
                <div class="flex items-end justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-900">Pertanyaan Seputar KPR</h2>
                        <p class="mt-1 text-sm text-gray-600">Jawaban singkat untuk pertanyaan paling sering ditanyakan.</p>
                    </div>
                    <button type="button" data-open-property-inquiry class="hidden md:inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                        <i class="fa-brands fa-whatsapp"></i>
                        Tanya via WhatsApp
                    </button>
                </div>

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

                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('calculator') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                        <i class="fa-solid fa-calculator"></i>
                        Simulasi KPR
                    </a>
                    <a href="{{ route('takeover') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                        <i class="fa-solid fa-right-left"></i>
                        Pindah KPR (Take Over)
                    </a>
                </div>
            </section>
        </div>
    </div>
@endsection
