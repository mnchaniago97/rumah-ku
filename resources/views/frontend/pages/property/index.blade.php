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
            if (blank($path)) return null;
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) return $path;
            return '/storage/' . ltrim($path, '/');
        };

        $formatRupiah = fn ($v) => filled($v) && is_numeric($v) ? 'Rp ' . number_format($v, 0, ',', '.') : 'Hubungi Kami';
        $totalResults = method_exists($properties, 'total') ? (int) $properties->total() : (is_countable($properties) ? count($properties) : 0);
    @endphp

    <div class="bg-gray-50">
        {{-- HERO --}}
        <div class="relative">
            <div class="relative mx-[16px] overflow-hidden rounded-b-[40px] md:mx-[50px]">
                <div class="absolute inset-0">
                    <img src="/assets/admin/images/product/product-01.jpg" class="h-full w-full object-cover" alt="Hero">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-blue-700/70"></div>
                </div>

                <div class="relative flex h-[260px] items-center md:h-[320px]">
                    <div class="max-w-[1200px] mx-auto w-full px-6">
                        <div class="max-w-2xl text-white">
                            <h1 class="text-3xl font-extrabold leading-tight md:text-4xl">Daftar Properti</h1>
                            <p class="mt-3 text-white/90">Temukan properti terbaik berdasarkan lokasi, tipe, dan kisaran harga.</p>
                            <div class="mt-4 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold text-white ring-1 ring-white/20">
                                <i class="fa fa-house"></i>
                                <span>Menampilkan {{ $totalResults }} properti</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- QUICK SEARCH --}}
        <section class="mt-6">
            <div class="max-w-[1200px] mx-auto px-4">
                <form action="{{ route('properties') }}" method="GET" class="rounded-2xl bg-white p-4 shadow-xl ring-1 ring-black/5">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <div class="grid gap-3 md:grid-cols-12">
                        <div class="md:col-span-6">
                            <input name="q" value="{{ request('q') }}" placeholder="Lokasi, keyword, area"
                                class="h-12 w-full rounded-xl border border-gray-200 px-4 text-sm focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div class="md:col-span-3">
                            <select name="city"
                                class="h-12 w-full rounded-xl border border-gray-200 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                                <option value="">Semua Kota</option>
                                @foreach(($cityOptions ?? collect()) as $city)
                                    <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <select name="type"
                                class="h-12 w-full rounded-xl border border-gray-200 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                                <option value="">Tipe</option>
                                @foreach(($typeOptions ?? collect()) as $t)
                                    <option value="{{ $t }}" @selected(request('type') === $t)>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <button type="submit"
                                class="inline-flex h-12 w-full items-center justify-center rounded-xl bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700">
                                <i class="fa fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        {{-- CONTENT --}}
        <div class="max-w-[1200px] mx-auto px-4 pt-8 pb-12">
            <div class="grid gap-6 lg:grid-cols-12">
                <aside class="lg:col-span-3">
                    <div class="space-y-3 lg:sticky lg:top-28">
                        <details class="lg:hidden">
                            <summary class="inline-flex w-full cursor-pointer items-center justify-between rounded-2xl bg-white px-5 py-4 text-sm font-extrabold text-gray-900 shadow-sm ring-1 ring-black/5">
                                <span>Filter</span>
                                <i class="fa fa-sliders"></i>
                            </summary>
                            <div class="mt-3">
                                @include('frontend.pages.property._filters')
                            </div>
                        </details>

                        <div class="hidden lg:block">
                            @include('frontend.pages.property._filters')
                        </div>
                    </div>
                </aside>

                <main class="lg:col-span-9">
                    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-lg font-extrabold text-gray-900">Hasil Pencarian</p>
                            <p class="text-sm text-gray-500">{{ $totalResults }} properti ditemukan</p>
                        </div>

                        <form method="GET" action="{{ route('properties') }}" class="flex items-center gap-2">
                            @foreach(request()->except(['sort', 'page']) as $key => $value)
                                @if(!is_array($value))
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <select name="sort" onchange="this.form.submit()"
                                class="h-11 rounded-xl border border-gray-200 bg-white px-4 text-sm focus:ring-2 focus:ring-blue-600">
                                <option value="" @selected(request('sort') === null || request('sort') === '')>Urutkan: Terbaru</option>
                                <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga: Termurah</option>
                                <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga: Termahal</option>
                                <option value="area_asc" @selected(request('sort') === 'area_asc')>Luas Tanah: Terkecil</option>
                                <option value="area_desc" @selected(request('sort') === 'area_desc')>Luas Tanah: Terbesar</option>
                            </select>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                        @forelse ($properties as $property)
                            @php
                                $rawImage = $property->images?->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                                    ?? $property->images?->sortBy('sort_order')->first()?->path;
                                $cardImage = $normalizeImage($rawImage) ?? $fallbackImages->random();
                                $permalink = $property->slug ?: $property->getKey();
                                $totalArea = (int) ($property->land_area ?? 0) + (int) ($property->building_area ?? 0);
                            @endphp

                            <a href="{{ route('property.show', $permalink) }}" class="block">
                                <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 hover:shadow-md transition">
                                    <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                                        <img src="{{ $cardImage }}" alt="{{ $property->title }}"
                                            class="h-full w-full object-cover hover:scale-105 transition duration-300" />
                                    </div>

                                    <div class="p-4">
                                        <p class="text-lg font-extrabold text-blue-700">
                                            {{ $formatRupiah($property->price) }}
                                        </p>
                                        <p class="mt-2 line-clamp-2 text-sm font-semibold text-gray-900">
                                            {{ $property->title }}
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">{{ $property->city ?? '-' }}</p>

                                        <div class="mt-3 flex items-center gap-3 text-xs text-gray-600">
                                            <span class="inline-flex items-center gap-1">
                                                <i class="fa fa-bed text-blue-900"></i>
                                                {{ $property->bedrooms ?? '-' }}
                                            </span>
                                            <span class="inline-flex items-center gap-1">
                                                <i class="fa fa-bath text-blue-900"></i>
                                                {{ $property->bathrooms ?? '-' }}
                                            </span>
                                            <span class="inline-flex items-center gap-1">
                                                <i class="fa fa-ruler-combined text-blue-900"></i>
                                                {{ $totalArea }} m²
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full rounded-2xl border border-dashed border-gray-200 bg-white p-12 text-center">
                                <i class="fa fa-home mb-3 text-4xl text-gray-300"></i>
                                <p class="text-gray-500">Belum ada properti yang sesuai filter.</p>
                            </div>
                        @endforelse
                    </div>

                    @if(method_exists($properties, 'links') && $properties instanceof \Illuminate\Contracts\Pagination\Paginator)
                        <div class="mt-8">
                            {{ $properties->links() }}
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
@endsection
