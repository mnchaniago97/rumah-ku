@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50">
        <section class="bg-gradient-to-br from-blue-800 to-indigo-700 py-14 text-white">
            <div class="max-w-[1200px] mx-auto px-4">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-semibold">Sewa</p>
                        <h1 class="mt-1 text-3xl md:text-4xl font-extrabold">Bantuan Sewa</h1>
                        <p class="mt-3 max-w-2xl text-white/90">
                            Punya pertanyaan soal sewa? Mulai dari proses, dokumen, sampai negosiasi harga—kami bantu.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('sewa') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-5 py-3 text-sm font-semibold text-white hover:bg-white/15">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="button" data-open-property-inquiry
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-800 hover:bg-white/90">
                            <i class="fa-brands fa-whatsapp"></i>
                            Konsultasi
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-[1200px] mx-auto px-4 py-12 space-y-10">
            <section class="grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['icon' => 'fa-solid fa-file-lines', 'title' => 'Dokumen', 'desc' => 'Checklist dokumen sewa dan persiapan awal.'],
                    ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Keamanan', 'desc' => 'Tips aman transaksi dan pengecekan unit.'],
                    ['icon' => 'fa-solid fa-handshake', 'title' => 'Negosiasi', 'desc' => 'Cara nego harga, durasi sewa, dan biaya tambahan.'],
                ] as $c)
                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-black/5">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                            <i class="{{ $c['icon'] }}"></i>
                        </div>
                        <h2 class="mt-4 text-lg font-extrabold text-gray-900">{{ $c['title'] }}</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ $c['desc'] }}</p>
                    </div>
                @endforeach
            </section>

            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm" x-data="{ open: 0 }">
                <h2 class="text-2xl font-extrabold text-gray-900">FAQ Sewa</h2>
                <p class="mt-2 text-sm text-gray-600">Pertanyaan yang paling sering ditanyakan.</p>

                @php
                    $faqs = [
                        [
                            'q' => 'Apa saja biaya yang umum saat sewa?',
                            'a' => 'Umumnya uang sewa, deposit (jika ada), biaya admin/maintenance (untuk apartemen), dan biaya utilitas. Detail tergantung pemilik/unit.',
                        ],
                        [
                            'q' => 'Berapa lama proses dari survey sampai deal?',
                            'a' => 'Tergantung kesepakatan dan kelengkapan dokumen, umumnya 1–7 hari untuk sampai penandatanganan/perjanjian.',
                        ],
                        [
                            'q' => 'Apa perbedaan sewa bulanan vs tahunan?',
                            'a' => 'Bulanan lebih fleksibel namun biasanya harga per bulan lebih tinggi. Tahunan lebih hemat dan umum untuk rumah/villa.',
                        ],
                        [
                            'q' => 'Bisa dibantu carikan unit sesuai budget?',
                            'a' => 'Bisa. Klik tombol konsultasi, sebutkan kota, budget, tipe properti, dan periode sewanya.',
                        ],
                    ];
                @endphp

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

            <section class="rounded-2xl bg-blue-800 p-8 text-white">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold">Siap cari properti sewa?</h3>
                        <p class="mt-1 text-sm text-white/85">Klik konsultasi atau kembali ke halaman sewa untuk filter unit.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('sewa') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-5 py-3 text-sm font-semibold text-white hover:bg-white/15">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            Cari Unit
                        </a>
                        <button type="button" data-open-property-inquiry
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-800 hover:bg-white/90">
                            <i class="fa-brands fa-whatsapp"></i>
                            Konsultasi Sekarang
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

