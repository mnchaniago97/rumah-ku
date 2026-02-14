@extends('frontend.layouts.app')

@section('content')
    @php
        $fallbackImages = collect([
            '/assets/admin/images/product/product-01.jpg',
            '/assets/admin/images/product/product-02.jpg',
            '/assets/admin/images/product/product-03.jpg',
            '/assets/admin/images/product/product-04.jpg',
        ]);

        $normalizeImage = function (?string $path) {
            if (blank($path)) {
                return null;
            }
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
                return $path;
            }
            return '/storage/' . ltrim($path, '/');
        };

        $formatRupiah = function ($value) {
            if (!filled($value) || !is_numeric($value)) {
                return 'Hubungi Kami';
            }
            return 'Rp ' . number_format((float) $value, 0, ',', '.');
        };
    @endphp

    <div class="bg-gray-50">
        {{-- Hero --}}
        <section class="relative overflow-hidden">
            <div class="absolute inset-0">
                <img src="/assets/admin/images/product/product-01.jpg" alt="Rumah Subsidi"
                    class="h-full w-full object-cover object-center" />
                <div class="absolute inset-0 bg-gradient-to-r from-blue-950/80 via-blue-950/60 to-blue-950/30"></div>
            </div>

            <div class="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-24 bottom-10 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>

            <div class="relative mx-auto max-w-[1200px] px-4 pt-10 pb-16 sm:pt-14 sm:pb-20">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:items-center lg:gap-10">
                    <div class="lg:col-span-7 lg:pr-6">
                        <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                            Cari Rumah Subsidi di Indonesia
                        </h1>
                        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-white/90 sm:text-base">
                            Temukan rumah subsidi dengan harga terjangkau, cicilan ringan, dan fasilitas lengkap.
                        </p>

                        <div class="mt-5 flex flex-wrap gap-2 text-xs sm:text-sm">
                            <a href="{{ route('calculator') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2 font-semibold text-white ring-1 ring-white/15 hover:bg-white/15">
                                <i class="fa fa-calculator"></i> Simulasi KPR
                            </a>
                            <button type="button" data-open-property-inquiry
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 font-semibold text-blue-950 hover:bg-white/90">
                                <i class="fa fa-headset"></i> Konsultasi
                            </button>
                        </div>
                    </div>

                    <div class="lg:col-span-5 lg:justify-self-end">
                        <form action="{{ route('rumah-subsidi') }}" method="GET"
                            class="w-full max-w-xl rounded-2xl bg-white/95 p-4 shadow-sm ring-1 ring-black/5 backdrop-blur">
                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-12">
                                    <div class="sm:col-span-12">
                                        <label class="sr-only">Cari</label>
                                        <div class="relative">
                                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                                                <i class="fa fa-magnifying-glass"></i>
                                            </span>
                                            <input name="q" value="{{ $filters['q'] ?? '' }}"
                                                placeholder="Ketik lokasi atau keyword..."
                                                class="h-11 w-full rounded-xl border border-gray-200 bg-white pl-10 pr-3 text-sm text-gray-800 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" />
                                        </div>
                                    </div>

                                    <div class="sm:col-span-6 mb-5 sm:mb-0">
                                        <label class="sr-only">Kota</label>
                                        <select name="city"
                                            class="h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm text-gray-800 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10">
                                            <option value="">Semua Kota</option>
                                            @foreach(($cityOptions ?? collect()) as $city)
                                                <option value="{{ $city }}" @selected(($filters['city'] ?? '') === $city)>{{ $city }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="sm:col-span-6">
                                        <label class="sr-only">Tipe</label>
                                        <select name="type"
                                            class="h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm text-gray-800 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10">
                                            <option value="">Semua Tipe</option>
                                            @foreach (['Rumah','Apartemen','Tanah','Ruko','Villa'] as $t)
                                                <option value="{{ $t }}" @selected(($filters['type'] ?? '') === $t)>{{ $t }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="sm:col-span-12">
                                        <button type="submit"
                                            class="inline-flex h-11 w-full items-center justify-center rounded-xl bg-blue-700 px-4 text-sm font-semibold text-white hover:bg-blue-800">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>

            <div class="pointer-events-none absolute inset-x-0 -bottom-1 h-16 rounded-t-[36px] bg-gray-50"></div>
        </section>

        <div class="mx-auto max-w-[1200px] px-4 py-8">
            {{-- Promo Banner --}}
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-12">
                <a href="{{ route('calculator') }}"
                    class="group relative overflow-hidden rounded-2xl bg-gray-200 ring-1 ring-black/5 lg:col-span-8">
                    <img src="/assets/admin/images/product/product-04.jpg" alt="Simulasi KPR"
                        class="absolute inset-0 h-full w-full object-cover transition group-hover:scale-105" />
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-950/70 via-blue-950/40 to-transparent"></div>
                    <div class="relative p-6 text-white">
                        <p class="text-xs font-semibold text-white/90">KPR Subsidi</p>
                        <h2 class="mt-1 text-xl font-extrabold">Cek Simulasi Cicilan &amp; Persyaratan</h2>
                        <p class="mt-1 max-w-lg text-sm text-white/90">Hitung estimasi cicilan dan dapatkan panduan proses pengajuan KPR subsidi.</p>
                        <span class="mt-4 inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-blue-950">
                            Cek Sekarang <i class="fa fa-arrow-right text-xs"></i>
                        </span>
                    </div>
                </a>

                <div class="grid grid-cols-1 gap-4 lg:col-span-4">
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                                <i class="fa fa-shield"></i>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Aman &amp; Terverifikasi</p>
                                <p class="mt-1 text-sm text-gray-600">Listing yang tampil hanya yang sudah disetujui Admin.</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-green-700">
                                <i class="fa fa-percent"></i>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Harga Terjangkau</p>
                                <p class="mt-1 text-sm text-gray-600">Temukan opsi rumah subsidi yang sesuai kemampuan Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section: Listing --}}
            <div class="mt-10 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Daftar Rumah Subsidi</h2>
                    <p class="mt-1 text-sm text-gray-600">Listing rumah subsidi yang ditentukan oleh Admin.</p>
                </div>
                @if(($filters['q'] ?? '') !== '' || ($filters['city'] ?? '') !== '' || ($filters['type'] ?? '') !== '')
                    <a href="{{ route('rumah-subsidi') }}" class="text-sm font-semibold text-blue-700 hover:underline">
                        Reset Filter
                    </a>
                @endif
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($properties as $property)
                    @php
                        $images = ($property->images ?? collect())->sortBy('sort_order')->values();
                        $primaryImage = $images->firstWhere('is_primary', true) ?? $images->first();
                        $imageSrc = $normalizeImage($primaryImage?->path) ?: $fallbackImages->random();
                        $addressText = collect([$property->address, $property->city, $property->province])->filter()->implode(', ');
                    @endphp

                    <a href="{{ route('property.show', $property->slug ?: $property->getKey()) }}"
                        class="block overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 transition hover:shadow-md">
                        <div class="relative aspect-[4/3] bg-gray-200">
                            <img src="{{ $imageSrc }}" alt="{{ $property->title }}" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                            <span class="absolute left-3 top-3 rounded-full bg-green-600 px-2.5 py-1 text-xs font-semibold text-white">Subsidi</span>
                        </div>
                        <div class="p-4">
                            <p class="text-base font-extrabold text-blue-700">{{ $formatRupiah($property->price) }}</p>
                            <p class="mt-1 line-clamp-2 text-sm font-semibold text-gray-900">{{ $property->title }}</p>
                            <p class="mt-1 line-clamp-1 text-xs text-gray-500">
                                <i class="fa fa-map-marker mr-1"></i>
                                {{ $addressText ?: 'Lokasi belum diisi' }}
                            </p>
                            <div class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-[11px] text-gray-500">
                                @if($property->bedrooms)
                                    <span><i class="fa fa-bed mr-1"></i>{{ $property->bedrooms }} KT</span>
                                @endif
                                @if($property->bathrooms)
                                    <span><i class="fa fa-shower mr-1"></i>{{ $property->bathrooms }} KM</span>
                                @endif
                                @if($property->land_area)
                                    <span><i class="fa fa-expand mr-1"></i>{{ number_format((float) $property->land_area) }} m²</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-gray-200 bg-white p-12 text-center">
                        <i class="fa fa-home mb-3 text-4xl text-gray-300"></i>
                        <p class="text-gray-600">Belum ada rumah subsidi yang tersedia.</p>
                        <button type="button" data-open-property-inquiry
                            class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-700 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-800">
                            <i class="fa fa-headset"></i> Minta Dicariin
                        </button>
                    </div>
                @endforelse
            </div>

            @if(method_exists($properties, 'links'))
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @endif

            {{-- Section: Populer --}}
            @if(($popularProperties ?? collect())->count() > 0)
                <div class="mt-12">
                    <div class="flex items-end justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Rumah Subsidi Populer</h3>
                        <a href="{{ route('properties') }}" class="text-sm font-semibold text-blue-700 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="mt-4 flex gap-4 overflow-x-auto pb-2">
                        @foreach($popularProperties as $p)
                            @php
                                $imgs = ($p->images ?? collect())->sortBy('sort_order')->values();
                                $primary = $imgs->firstWhere('is_primary', true) ?? $imgs->first();
                                $imgSrc = $normalizeImage($primary?->path) ?: $fallbackImages->random();
                            @endphp
                            <a href="{{ route('property.show', $p->slug ?: $p->getKey()) }}"
                                class="min-w-[240px] overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 hover:shadow-md">
                                <div class="relative aspect-[4/3] bg-gray-200">
                                    <img src="{{ $imgSrc }}" alt="{{ $p->title }}" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                                    <span class="absolute left-3 top-3 rounded-full bg-amber-500 px-2.5 py-1 text-xs font-semibold text-white">Populer</span>
                                </div>
                                <div class="p-4">
                                    <p class="text-sm font-extrabold text-blue-700">{{ $formatRupiah($p->price) }}</p>
                                    <p class="mt-1 line-clamp-2 text-sm font-semibold text-gray-900">{{ $p->title }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Section: Pilihan Untukmu --}}
            @if(($ourChoiceProperties ?? collect())->count() > 0)
                <div class="mt-12">
                    <div class="flex items-end justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Rekomendasi Rumah Subsidi</h3>
                        <a href="{{ route('properties') }}" class="text-sm font-semibold text-blue-700 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="mt-4 flex gap-4 overflow-x-auto pb-2">
                        @foreach($ourChoiceProperties as $p)
                            @php
                                $imgs = ($p->images ?? collect())->sortBy('sort_order')->values();
                                $primary = $imgs->firstWhere('is_primary', true) ?? $imgs->first();
                                $imgSrc = $normalizeImage($primary?->path) ?: $fallbackImages->random();
                            @endphp
                            <a href="{{ route('property.show', $p->slug ?: $p->getKey()) }}"
                                class="min-w-[240px] overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 hover:shadow-md">
                                <div class="relative aspect-[4/3] bg-gray-200">
                                    <img src="{{ $imgSrc }}" alt="{{ $p->title }}" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                                </div>
                                <div class="p-4">
                                    <p class="text-sm font-extrabold text-blue-700">{{ $formatRupiah($p->price) }}</p>
                                    <p class="mt-1 line-clamp-2 text-sm font-semibold text-gray-900">{{ $p->title }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Section: FAQ --}}
            <div class="mt-12">
                <h3 class="text-lg font-bold text-gray-900">Pertanyaan yang sering ditanyakan</h3>
                <div class="mt-4 divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white ring-1 ring-black/5">
                    @foreach ([
                        ['q' => 'Apa itu rumah subsidi?', 'a' => 'Rumah subsidi adalah program perumahan dengan harga terjangkau yang umumnya didukung oleh pemerintah atau skema pembiayaan khusus.'],
                        ['q' => 'Bagaimana cara pengajuan KPR subsidi?', 'a' => 'Siapkan dokumen (KTP, KK, slip gaji/dokumen usaha), pilih unit, lalu ajukan KPR melalui bank rekanan.'],
                        ['q' => 'Bagaimana cara mendapatkan listing yang sesuai?', 'a' => 'Gunakan pencarian di atas atau klik Konsultasi agar tim kami membantu mencarikan rumah subsidi sesuai kebutuhan Anda.'],
                    ] as $item)
                        <details class="group p-5">
                            <summary class="flex cursor-pointer list-none items-center justify-between text-sm font-semibold text-gray-900">
                                <span>{{ $item['q'] }}</span>
                                <span class="text-gray-400 transition group-open:rotate-180">
                                    <i class="fa fa-chevron-down"></i>
                                </span>
                            </summary>
                            <p class="mt-3 text-sm text-gray-600">{{ $item['a'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>

            {{-- Section: Articles --}}
            @if(($articles ?? collect())->count() > 0)
                <div class="mt-12">
                    <div class="flex items-end justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Info &amp; Tips Properti</h3>
                        <a href="{{ route('articles') }}" class="text-sm font-semibold text-blue-700 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-4">
                        @foreach($articles as $a)
                            @php
                                $img = !empty($a->image) ? (str_starts_with($a->image, 'http') || str_starts_with($a->image, '/') ? $a->image : '/storage/' . ltrim($a->image, '/')) : $fallbackImages->random();
                            @endphp
                            <a href="{{ route('articles.show', $a->slug) }}" class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 hover:shadow-md">
                                <div class="relative aspect-[16/10] bg-gray-200">
                                    <img src="{{ $img }}" alt="{{ $a->title }}" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                                </div>
                                <div class="p-4">
                                    <p class="line-clamp-2 text-sm font-semibold text-gray-900">{{ $a->title }}</p>
                                    <p class="mt-1 text-xs text-gray-500">{{ optional($a->published_at)->format('d M Y') }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
