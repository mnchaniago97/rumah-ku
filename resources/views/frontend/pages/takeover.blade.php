@extends('frontend.layouts.app')

@section('content')
    @php
        $programs = [
            [
                'bank' => 'BCA',
                'title' => 'Take Over KPR',
                'badge' => 'Populer',
                'badge_class' => 'bg-blue-50 text-blue-700',
                'fix_rate' => 5.25,
                'fix_years' => 3,
                'floating_note' => 'Floating mengikuti pasar setelah periode fix.',
                'provisi' => '0.5% – 1%',
                'admin' => 'Rp 1.000.000',
                'appraisal' => 'Rp 750.000',
            ],
            [
                'bank' => 'Mandiri',
                'title' => 'Take Over KPR',
                'badge' => 'Cepat',
                'badge_class' => 'bg-emerald-50 text-emerald-700',
                'fix_rate' => 5.75,
                'fix_years' => 2,
                'floating_note' => 'Floating tergantung kebijakan bank.',
                'provisi' => '0.75% – 1%',
                'admin' => 'Rp 1.250.000',
                'appraisal' => 'Rp 800.000',
            ],
            [
                'bank' => 'BRI',
                'title' => 'Take Over KPR',
                'badge' => 'Hemat',
                'badge_class' => 'bg-amber-50 text-amber-800',
                'fix_rate' => 6.10,
                'fix_years' => 3,
                'floating_note' => 'Tersedia skema fix+floating.',
                'provisi' => '0.5% – 1%',
                'admin' => 'Rp 900.000',
                'appraisal' => 'Rp 750.000',
            ],
            [
                'bank' => 'BNI',
                'title' => 'Take Over KPR',
                'badge' => 'Fix+Float',
                'badge_class' => 'bg-indigo-50 text-indigo-700',
                'fix_rate' => 5.95,
                'fix_years' => 3,
                'floating_note' => 'Floating setelah fix berakhir.',
                'provisi' => '0.75% – 1.25%',
                'admin' => 'Rp 1.000.000',
                'appraisal' => 'Rp 850.000',
            ],
            [
                'bank' => 'CIMB Niaga',
                'title' => 'Take Over KPR',
                'badge' => 'Promo',
                'badge_class' => 'bg-pink-50 text-pink-700',
                'fix_rate' => 5.15,
                'fix_years' => 1,
                'floating_note' => 'Promo bisa berubah sewaktu-waktu.',
                'provisi' => '0.5% – 1%',
                'admin' => 'Rp 1.500.000',
                'appraisal' => 'Rp 900.000',
            ],
            [
                'bank' => 'BTN',
                'title' => 'Take Over KPR',
                'badge' => 'Rumah',
                'badge_class' => 'bg-slate-100 text-slate-700',
                'fix_rate' => 6.25,
                'fix_years' => 2,
                'floating_note' => 'Floating sesuai ketentuan bank.',
                'provisi' => '0.5% – 1%',
                'admin' => 'Rp 900.000',
                'appraisal' => 'Rp 750.000',
            ],
        ];

        $faqs = [
            [
                'q' => 'Apa itu take over KPR?',
                'a' => 'Take over KPR adalah proses memindahkan fasilitas KPR dari bank lama ke bank baru, biasanya untuk mendapatkan bunga lebih kompetitif atau menyesuaikan cicilan.',
            ],
            [
                'q' => 'Kapan take over KPR menguntungkan?',
                'a' => 'Umumnya saat bunga bank baru lebih rendah, ada kebutuhan menurunkan cicilan, atau ingin memperbaiki cashflow. Tetap hitung biaya-biaya (provisi, admin, appraisal) agar hasilnya optimal.',
            ],
            [
                'q' => 'Dokumen apa yang dibutuhkan?',
                'a' => 'Mirip pengajuan KPR: dokumen identitas, penghasilan, dan dokumen properti. Kamu bisa cek halaman checklist dokumen untuk gambaran umumnya.',
            ],
            [
                'q' => 'Berapa lama prosesnya?',
                'a' => 'Rata-rata 7–21 hari kerja tergantung kelengkapan dokumen, appraisal, dan proses di bank lama & bank baru.',
            ],
        ];
    @endphp

    <div class="bg-gray-50">
        {{-- Hero --}}
        <section class="relative overflow-hidden bg-gradient-to-br from-indigo-800 via-blue-700 to-blue-600 py-14 text-white">
            <div class="absolute inset-0 opacity-20">
                <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/20 blur-2xl"></div>
                <div class="pointer-events-none absolute -left-24 -bottom-24 h-72 w-72 rounded-full bg-white/10 blur-2xl"></div>
            </div>
            <div class="max-w-[1200px] mx-auto px-4 relative">
                <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                    <div>
                        <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold tracking-wide">
                            <i class="fa-solid fa-right-left"></i>
                            Pindah KPR (Take Over)
                        </p>
                        <h1 class="mt-4 text-3xl md:text-4xl font-extrabold leading-tight">
                            Take Over KPR, pindah KPR jadi lebih mudah.
                        </h1>
                        <p class="mt-3 max-w-xl text-white/85">
                            Bandingkan program take over dari beberapa bank pilihan. Hitung kebutuhanmu, lalu konsultasi biar prosesnya cepat dan aman.
                        </p>
                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('kpr') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-5 py-3 text-sm font-semibold text-white hover:bg-white/15">
                                <i class="fa-solid fa-arrow-left"></i>
                                Kembali ke KPR
                            </a>
                            <button type="button" data-open-property-inquiry
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-800 hover:bg-white/90">
                                <i class="fa-brands fa-whatsapp"></i>
                                Konsultasi Take Over
                            </button>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-6 ring-1 ring-white/15">
                        <p class="text-sm font-semibold">Paling sering dicari</p>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            @foreach ([
                                ['icon' => 'fa-solid fa-percent', 'label' => 'Bunga lebih rendah'],
                                ['icon' => 'fa-solid fa-arrow-trend-down', 'label' => 'Cicilan turun'],
                                ['icon' => 'fa-solid fa-shield', 'label' => 'Proses aman'],
                                ['icon' => 'fa-solid fa-file-lines', 'label' => 'Dokumen dibantu'],
                            ] as $t)
                                <div class="rounded-xl bg-white/10 p-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/10">
                                        <i class="{{ $t['icon'] }}"></i>
                                    </div>
                                    <p class="mt-3 text-sm font-semibold">{{ $t['label'] }}</p>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-4 text-xs text-white/70">Program & biaya dapat berubah sesuai kebijakan bank.</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-[1200px] mx-auto px-4 py-12 space-y-10"
            x-data="{
                q: '',
                maxFix: 7,
                items: @js($programs),
                get filtered() {
                    const s = (this.q || '').toLowerCase().trim();
                    return this.items
                        .filter(i => i.fix_rate <= this.maxFix)
                        .filter(i => !s || (i.bank + ' ' + i.title).toLowerCase().includes(s));
                }
            }">

            {{-- Filter + Program list --}}
            <section class="grid gap-6 lg:grid-cols-12">
                <aside class="lg:col-span-4">
                    <div class="bg-white rounded-2xl p-6 shadow-sm sticky top-20">
                        <h2 class="text-lg font-extrabold text-gray-900">Filter Cepat</h2>
                        <p class="mt-1 text-sm text-gray-600">Sesuaikan biar makin relevan.</p>

                        <div class="mt-6 space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Cari bank</label>
                                <div class="relative mt-2">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input type="text" x-model="q" placeholder="Contoh: BCA"
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-10 pr-3 text-sm text-gray-800 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-200">
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label class="block text-sm font-semibold text-gray-700">Maks bunga fix</label>
                                    <span class="text-sm font-bold text-blue-700" x-text="maxFix.toFixed(2) + '%'"></span>
                                </div>
                                <input type="range" min="4" max="12" step="0.05" x-model.number="maxFix"
                                    class="mt-2 w-full">
                                <p class="mt-1 text-xs text-gray-500">Filter ini hanya untuk bunga fix (promo awal).</p>
                            </div>

                            <div class="rounded-xl bg-blue-50 p-4">
                                <p class="text-sm font-semibold text-gray-900">Butuh hitung cicilan juga?</p>
                                <p class="mt-1 text-xs text-gray-600">Pakai simulasi KPR untuk estimasi cicilan per bulan.</p>
                                <a href="{{ route('calculator') }}" class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                                    <i class="fa-solid fa-calculator"></i>
                                    Buka Simulasi
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="lg:col-span-8">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-extrabold text-gray-900">Program Take Over</h2>
                            <p class="mt-1 text-sm text-gray-600">Pilih program, lalu konsultasi untuk detail syarat & biaya.</p>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">
                            <span x-text="filtered.length"></span> program
                        </p>
                    </div>

                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        <template x-for="(p, idx) in filtered" :key="idx">
                            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-extrabold text-gray-900" x-text="p.bank"></p>
                                        <p class="text-xs text-gray-500" x-text="p.title"></p>
                                    </div>
                                    <span class="rounded-full px-2 py-1 text-[11px] font-semibold"
                                        :class="p.badge_class" x-text="p.badge"></span>
                                </div>

                                <div class="mt-4 rounded-xl bg-gray-50 p-4">
                                    <p class="text-xs font-semibold text-gray-500">Bunga fix</p>
                                    <p class="mt-1 text-2xl font-extrabold text-blue-800">
                                        <span x-text="p.fix_rate.toFixed(2)"></span><span class="text-base font-bold">%</span>
                                        <span class="ml-1 text-sm font-semibold text-gray-600" x-text="'/' + p.fix_years + ' th'"></span>
                                    </p>
                                    <p class="mt-2 text-xs text-gray-500" x-text="p.floating_note"></p>
                                </div>

                                <div class="mt-4 grid grid-cols-3 gap-3 text-xs">
                                    <div class="rounded-xl bg-white ring-1 ring-gray-100 p-3">
                                        <p class="text-gray-500">Provisi</p>
                                        <p class="mt-1 font-bold text-gray-900" x-text="p.provisi"></p>
                                    </div>
                                    <div class="rounded-xl bg-white ring-1 ring-gray-100 p-3">
                                        <p class="text-gray-500">Admin</p>
                                        <p class="mt-1 font-bold text-gray-900" x-text="p.admin"></p>
                                    </div>
                                    <div class="rounded-xl bg-white ring-1 ring-gray-100 p-3">
                                        <p class="text-gray-500">Appraisal</p>
                                        <p class="mt-1 font-bold text-gray-900" x-text="p.appraisal"></p>
                                    </div>
                                </div>

                                <div class="mt-5 flex gap-2">
                                    <button type="button" data-open-property-inquiry
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                                        <i class="fa-solid fa-message"></i>
                                        Tanya Program
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="mt-6 text-xs text-gray-500">
                        Disclaimer: Angka di atas contoh ringkas. Detail (bunga, biaya, tenor, dan syarat) mengikuti kebijakan bank.
                    </div>
                </div>
            </section>

            {{-- Tahapan --}}
            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                <h2 class="text-2xl font-extrabold text-gray-900">Tahapan Take Over</h2>
                <p class="mt-1 text-sm text-gray-600">Alur umum take over dari awal hingga selesai.</p>
                <div class="mt-6 grid gap-4 md:grid-cols-5">
                    @foreach ([
                        ['01', 'Konsultasi', 'Cek kebutuhan dan target cicilan/bunga.'],
                        ['02', 'Cek dokumen', 'Siapkan identitas, penghasilan, dan properti.'],
                        ['03', 'Proses bank baru', 'SLIK, verifikasi, dan appraisal.'],
                        ['04', 'Pelunasan ke bank lama', 'Pencairan untuk menutup sisa pokok.'],
                        ['05', 'Akad bank baru', 'Tanda tangan akad & mulai cicilan baru.'],
                    ] as $s)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                            <p class="text-xs font-bold text-blue-700">{{ $s[0] }}</p>
                            <p class="mt-2 font-bold text-gray-900">{{ $s[1] }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $s[2] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- FAQ --}}
            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm" x-data="{ open: 0 }">
                <div class="flex items-end justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-900">Pertanyaan Seputar Take Over</h2>
                        <p class="mt-1 text-sm text-gray-600">Jawaban singkat untuk pertanyaan paling umum.</p>
                    </div>
                    <a href="{{ route('kpr.dokumen') }}" class="hidden md:inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800">
                        <i class="fa-solid fa-file-lines"></i>
                        Checklist Dokumen
                    </a>
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
            </section>

            {{-- CTA --}}
            <section class="rounded-2xl bg-blue-800 p-8 text-white">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold">Siap pindah KPR?</h3>
                        <p class="mt-1 text-sm text-white/85">Klik konsultasi, tim kami bantu cek opsi terbaik dan hitung biayanya.</p>
                    </div>
                    <button type="button" data-open-property-inquiry
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-800 hover:bg-white/90">
                        <i class="fa-brands fa-whatsapp"></i>
                        Konsultasi Sekarang
                    </button>
                </div>
            </section>
        </div>
    </div>
@endsection
