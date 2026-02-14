@extends('frontend.layouts.app')

@section('content')
    @php
        $sections = [
            [
                'title' => 'Dokumen Pribadi',
                'items' => [
                    'KTP pemohon & pasangan (jika menikah)',
                    'Kartu Keluarga (KK)',
                    'NPWP (jika ada / sesuai ketentuan bank)',
                    'Buku nikah / akta cerai (jika diperlukan)',
                ],
                'icon' => 'fa-solid fa-id-card',
                'color' => 'text-blue-700',
                'bg' => 'bg-blue-50',
            ],
            [
                'title' => 'Dokumen Penghasilan',
                'items' => [
                    'Slip gaji 3 bulan terakhir / surat keterangan penghasilan',
                    'Surat keterangan kerja (masa kerja/jabatan)',
                    'Rekening koran/mutasi 3–6 bulan terakhir',
                    'Dokumen usaha (SIUP/NIB, laporan keuangan) untuk wiraswasta',
                ],
                'icon' => 'fa-solid fa-money-check-dollar',
                'color' => 'text-emerald-700',
                'bg' => 'bg-emerald-50',
            ],
            [
                'title' => 'Dokumen Properti',
                'items' => [
                    'Brosur/price list/booking form (rumah baru)',
                    'Sertifikat (SHM/SHGB), IMB/PBG (jika ada) untuk rumah second',
                    'PBB terakhir',
                    'Denah dan alamat lengkap properti',
                ],
                'icon' => 'fa-solid fa-house',
                'color' => 'text-indigo-700',
                'bg' => 'bg-indigo-50',
            ],
            [
                'title' => 'Dokumen Tambahan',
                'items' => [
                    'Bukti aset/tabungan (jika diminta bank)',
                    'Surat pernyataan (sesuai form bank)',
                    'Dokumen penjamin (jika diperlukan)',
                ],
                'icon' => 'fa-solid fa-folder-open',
                'color' => 'text-amber-700',
                'bg' => 'bg-amber-50',
            ],
        ];

        $tips = [
            'Siapkan file scan/foto yang jelas (tidak blur) agar verifikasi lebih cepat.',
            'Pastikan nama & alamat konsisten di semua dokumen.',
            'Untuk wiraswasta, mutasi rekening dan laporan usaha biasanya paling diperhatikan.',
            'Jika ada cicilan lain, jaga kolektibilitas tetap lancar (SLIK).',
        ];
    @endphp

    <div class="bg-gray-50">
        <section class="bg-gradient-to-br from-indigo-800 to-blue-700 py-14 text-white">
            <div class="max-w-[1200px] mx-auto px-4">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-semibold">KPR</p>
                        <h1 class="mt-1 text-3xl md:text-4xl font-extrabold">Checklist Dokumen KPR</h1>
                        <p class="mt-3 max-w-2xl text-white/90">
                            Daftar dokumen yang umum diminta bank. Bisa berbeda tergantung program dan profil pemohon.
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('kpr') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white/10 px-5 py-3 text-sm font-semibold text-white hover:bg-white/15">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali
                        </a>
                        <a href="{{ route('calculator') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-800 hover:bg-white/90">
                            <i class="fa-solid fa-calculator"></i>
                            Simulasi Cicilan
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-[1200px] mx-auto px-4 py-12 space-y-10">
            <section class="grid gap-4 md:grid-cols-2">
                @foreach ($sections as $s)
                    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $s['bg'] }} {{ $s['color'] }}">
                                <i class="{{ $s['icon'] }}"></i>
                            </div>
                            <h2 class="text-xl font-extrabold text-gray-900">{{ $s['title'] }}</h2>
                        </div>
                        <ul class="mt-5 space-y-3 text-sm text-gray-700">
                            @foreach ($s['items'] as $item)
                                <li class="flex items-start gap-3">
                                    <i class="fa-solid fa-circle-check mt-0.5 text-gray-400"></i>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </section>

            <section class="bg-white rounded-2xl p-6 md:p-8 shadow-sm">
                <h2 class="text-2xl font-extrabold text-gray-900">Tips Biar Cepat Disetujui</h2>
                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    @foreach ($tips as $t)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-lightbulb mt-0.5 text-amber-600"></i>
                                <p class="text-sm text-gray-700">{{ $t }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="rounded-2xl bg-blue-800 p-8 text-white">
                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-extrabold">Butuh dibantu cek dokumen?</h3>
                        <p class="mt-1 text-sm text-white/85">Klik tombol konsultasi, tim kami bantu review sebelum diajukan ke bank.</p>
                    </div>
                    <button type="button" data-open-property-inquiry
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-800 hover:bg-white/90">
                        <i class="fa-brands fa-whatsapp"></i>
                        Konsultasi Dokumen
                    </button>
                </div>
            </section>
        </div>
    </div>
@endsection

