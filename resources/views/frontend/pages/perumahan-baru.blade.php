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
        <div class="relative overflow-hidden">
            <div class="absolute inset-0">
                <img src="/assets/admin/images/product/product-02.jpg" alt="Perumahan Baru" class="h-full w-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 via-blue-800/70 to-indigo-700/60"></div>
            </div>

            <div class="relative mx-auto max-w-[1200px] px-4 pt-14 pb-20">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:items-center">
                    <div class="lg:col-span-7">
                        <h1 class="text-3xl font-extrabold tracking-tight text-white">Cari Perumahan Baru di Indonesia</h1>
                        <p class="mt-2 max-w-2xl text-sm text-white/90">
                            Temukan perumahan terbaru, pilihan lokasi terbaik, dan info properti terkini.
                        </p>
                    </div>
                    <div class="lg:col-span-5">
                        <form action="{{ route('perumahan-baru') }}" method="GET"
                            class="rounded-2xl bg-white/95 p-4 shadow-sm ring-1 ring-black/5 backdrop-blur">
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-12">
                                <div class="sm:col-span-12">
                                    <label class="sr-only">Cari</label>
                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                                            <i class="fa fa-magnifying-glass"></i>
                                        </span>
                                        <input name="q" value="{{ $filters['q'] ?? '' }}"
                                            placeholder="Ketik lokasi, keyword, developer..."
                                            class="h-11 w-full rounded-xl border border-gray-200 bg-white pl-10 pr-3 text-sm text-gray-800 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" />
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
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

            <div class="pointer-events-none absolute inset-x-0 bottom-0 h-12 bg-gray-50 rounded-t-[28px]"></div>
        </div>

        <div class="mx-auto max-w-[1200px] px-4 py-8">
            {{-- Section: Properti Baru --}}
            <div class="flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Daftar Perumahan Baru</h2>
                    <p class="mt-1 text-sm text-gray-600">Listing perumahan baru yang ditentukan oleh Admin.</p>
                </div>
                @if(($filters['q'] ?? '') !== '' || ($filters['city'] ?? '') !== '' || ($filters['type'] ?? '') !== '')
                    <a href="{{ route('perumahan-baru') }}" class="text-sm font-semibold text-blue-700 hover:underline">
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
                            <span class="absolute left-3 top-3 rounded-full bg-blue-700 px-2.5 py-1 text-xs font-semibold text-white">Baru</span>
                        </div>
                        <div class="p-4">
                            <p class="text-base font-extrabold text-blue-700">{{ $formatRupiah($property->price) }}</p>
                            <p class="mt-1 line-clamp-2 text-sm font-semibold text-gray-900">{{ $property->title }}</p>
                            <p class="mt-1 line-clamp-1 text-xs text-gray-500">
                                <i class="fa fa-map-marker mr-1"></i>
                                {{ $addressText ?: 'Lokasi belum diisi' }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-gray-200 bg-white p-12 text-center">
                        <i class="fa fa-city mb-3 text-4xl text-gray-300"></i>
                        <p class="text-gray-600">Belum ada perumahan baru yang tersedia.</p>
                        <p class="mt-1 text-sm text-gray-500">Admin dapat menandai properti ke kategori listing <span class="font-semibold">Properti Baru</span>.</p>
                    </div>
                @endforelse
            </div>

            @if(method_exists($properties, 'links'))
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @endif

            {{-- Section: Pilihan Untukmu --}}
            @if(($ourChoiceProperties ?? collect())->count() > 0)
                <div class="mt-12">
                    <div class="flex items-end justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Properti Pilihan Untukmu</h3>
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
                        ['q' => 'Apa itu perumahan baru?', 'a' => 'Perumahan baru adalah listing properti terbaru yang ditentukan oleh Admin sebagai proyek/perumahan terbaru.'],
                        ['q' => 'Bagaimana cara booking unit?', 'a' => 'Klik detail properti lalu hubungi agen via WhatsApp untuk konsultasi dan booking.'],
                        ['q' => 'Apakah bisa KPR?', 'a' => 'Bisa. Gunakan menu KPR atau konsultasi untuk simulasi cicilan.'],
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
                        <h3 class="text-lg font-bold text-gray-900">Berita Properti</h3>
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
