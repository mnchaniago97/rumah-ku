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

    $formatRupiah = fn($v) => filled($v) && is_numeric($v) ? 'Rp ' . number_format($v,0,',','.') : 'Hubungi Kami';
    $formatPhone = function (?string $phone) {
        $digits = preg_replace('/\D+/', '', (string) $phone);
        if ($digits === '') return null;
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }
        return '+' . $digits;
    };

    $makeWhatsApp = function ($p) use ($formatPhone) {
        $sourcePhone = $p->whatsapp_phone ?? $p->agent?->phone ?? $p->user?->phone ?? null;
        $formatted = $formatPhone($sourcePhone);
        if (!$formatted) return null;
        $digits = preg_replace('/\D+/', '', $formatted);
        return $digits ? "https://wa.me/$digits" : null;
    };

    $filtersActive = request()->filled('q')
        || request()->filled('city')
        || request()->filled('type');
@endphp

<div class="bg-gray-50">

    {{-- HERO --}}
    <div class="relative">
        <div class="absolute inset-0">
            <img src="/assets/admin/images/product/product-03.jpg" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-blue-700/70"></div>
        </div>

        <div class="relative max-w-[1200px] mx-auto px-4 pt-16 pb-24">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl font-extrabold leading-tight">
                    Investasi Masa Depan Dimulai dari Properti yang Tepat
                </h1>
                <p class="mt-3 text-white/90">
                    Temukan rumah, apartemen, villa, dan ruang usaha terbaik dengan mudah.
                </p>
            </div>

            {{-- SEARCH --}}
            <div class="mt-8 max-w-4xl mb-6">
                <form action="{{ route('sewa') }}" method="GET"
                    class="bg-white rounded-2xl shadow-xl p-4">
                    <div class="grid md:grid-cols-12 gap-3">
                        <div class="md:col-span-5">
                            <input name="q" value="{{ request('q') }}"
                                placeholder="Lokasi, keyword, area"
                                class="h-12 w-full rounded-xl border border-gray-200 px-4 text-sm focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div class="md:col-span-3">
                            <select name="city"
                                class="h-12 w-full rounded-xl border border-gray-200 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                                <option value="">Semua Kota</option>
                                @foreach(($cityOptions ?? collect()) as $city)
                                    <option value="{{ $city }}" @selected(request('city')==$city)>{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <select name="type"
                                class="h-12 w-full rounded-xl border border-gray-200 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                                <option value="">Tipe</option>
                                @foreach(($typeOptions ?? collect()) as $t)
                                    <option value="{{ $t }}" @selected(request('type')==$t)>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <button class="h-12 w-full rounded-xl bg-blue-700 text-white font-semibold hover:bg-blue-800">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- SHORTCUT --}}
            <div class="mt-10 grid grid-cols-4 md:grid-cols-8 gap-4">
                @php
                    $baseParams = array_filter([
                        'q' => request('q'),
                        'city' => request('city'),
                    ], fn ($v) => filled($v));

                    $shortcuts = [
                        ['label' => 'Rumah', 'icon' => 'fa-house', 'params' => ['type' => 'Rumah']],
                        ['label' => 'Apartemen', 'icon' => 'fa-building', 'params' => ['type' => 'Apartemen']],
                        ['label' => 'Villa', 'icon' => 'fa-umbrella-beach', 'params' => ['type' => 'Villa']],
                        ['label' => 'Ruko', 'icon' => 'fa-store', 'params' => ['type' => 'Ruko']],
                        ['label' => 'Tanah', 'icon' => 'fa-mountain', 'params' => ['type' => 'Tanah']],
                        ['label' => 'Bulanan', 'icon' => 'fa-calendar', 'params' => ['period' => 'bulan']],
                        ['label' => 'Tahunan', 'icon' => 'fa-calendar-check', 'params' => ['period' => 'tahun']],
                        ['label' => 'Bantuan', 'icon' => 'fa-headset', 'href' => route('contact')],
                    ];
                @endphp

                @foreach($shortcuts as $s)
                    @php
                        $href = $s['href'] ?? route('sewa', array_filter(array_merge($baseParams, $s['params'] ?? []), fn ($v) => filled($v)));
                    @endphp
                    <a href="{{ $href }}" class="text-center text-white group">
                        <div class="mx-auto mb-2 h-14 w-14 flex items-center justify-center rounded-full bg-white/20 backdrop-blur group-hover:bg-white/30">
                            <i class="fa {{ $s['icon'] }}"></i>
                        </div>
                        <div class="text-xs font-semibold">{{ $s['label'] }}</div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-10 bg-gray-50 rounded-t-[30px]"></div>
    </div>

    <div class="max-w-[1200px] mx-auto px-4 py-10 space-y-14">

    {{-- ========================= --}}
    {{-- KOTA POPULER --}}
    {{-- ========================= --}}
    <section>
        <div class="flex items-end justify-between">
            <div>
                <h2 class="text-xl font-bold">Kota Populer Untuk Sewa Hunian</h2>
                <p class="text-sm text-gray-500">Pilih kota favoritmu.</p>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach(($popularCities ?? collect()) as $row)
                <a href="{{ route('sewa',['city'=>$row['city']]) }}"
                    class="group relative overflow-hidden rounded-2xl">
                    <img src="{{ $normalizeImage($row['image'] ?? null) ?? 'https://source.unsplash.com/400x300/?city' }}"
                        class="h-28 w-full object-cover group-hover:scale-105 transition">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60"></div>
                    <div class="absolute bottom-2 left-3 text-white">
                        <div class="font-bold">{{ $row['city'] }}</div>
                        <div class="text-xs">{{ $row['total'] ?? 0 }} listing</div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>



    {{-- ========================= --}}
    {{-- REKOMENDASI RUMAH --}}
    {{-- ========================= --}}
    <section>
        <div class="flex justify-between items-end">
            <h2 class="text-xl font-bold">Rekomendasi Sewa Rumah</h2>
            <a href="{{ route('sewa') }}" class="text-blue-700 text-sm font-semibold">Lihat Semua</a>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(($houseRentals ?? collect()) as $property)
                @php
                    $img = optional($property->images->first())->path ?? 'https://source.unsplash.com/400x300/?house';
                    $wa = $makeWhatsApp($property);
                    $waNumber = $formatPhone($property->whatsapp_phone ?? $property->agent?->phone ?? $property->user?->phone ?? null);
                @endphp

                <div class="bg-white rounded-2xl shadow ring-1 ring-black/5 overflow-hidden">
                    <div class="aspect-[4/3]">
                        <img src="{{ $img }}" class="w-full h-full object-cover">
                    </div>

                    <div class="p-4">
                        <div class="text-blue-700 font-bold text-sm">
                            Rp {{ number_format($property->price,0,',','.') }}
                        </div>
                        <div class="mt-1 text-sm font-semibold line-clamp-2">
                            {{ $property->title }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            <i class="fa fa-map-marker mr-1"></i>{{ $property->city }}
                        </div>

                        @if($wa)
                            <a href="{{ $wa }}" target="_blank" rel="noopener"
                                class="mt-3 flex justify-center items-center gap-2 bg-green-600 text-white h-10 rounded-xl font-semibold">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                            </a>
                            @if($waNumber)
                                <div class="mt-2 text-center text-xs text-gray-500">WA: {{ $waNumber }}</div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>



    {{-- ========================= --}}
    {{-- KOST & APARTEMEN --}}
    {{-- ========================= --}}
    <section class="rounded-3xl p-6 bg-gradient-to-r from-blue-800 to-indigo-700 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">Sewa Kost & Apartemen</h2>
                <p class="text-sm text-white/80">Hunian praktis dekat pusat kota.</p>
            </div>
            <a href="{{ route('sewa',['type'=>'Apartemen']) }}"
                class="bg-white text-blue-800 px-4 py-2 rounded-xl text-sm font-semibold">
                Lihat Semua
            </a>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(($apartmentRentals ?? collect())->merge($kostRentals ?? collect())->take(8) as $property)
                @php
                    $img = optional($property->images->first())->path ?? 'https://source.unsplash.com/400x300/?apartment';
                    $wa = $makeWhatsApp($property);
                    $waNumber = $formatPhone($property->whatsapp_phone ?? $property->agent?->phone ?? $property->user?->phone ?? null);
                @endphp

                <div class="bg-white text-gray-900 rounded-2xl overflow-hidden shadow ring-1 ring-black/5">
                    <div class="aspect-[4/3]">
                        <img src="{{ $img }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <div class="font-bold text-blue-700 text-sm">
                            Rp {{ number_format($property->price,0,',','.') }}
                        </div>
                        <div class="text-sm font-semibold line-clamp-2 mt-1">
                            {{ $property->title }}
                        </div>

                        @if($wa)
                            <a href="{{ $wa }}" target="_blank" rel="noopener"
                                class="mt-3 flex justify-center items-center gap-2 bg-green-600 text-white h-10 rounded-xl font-semibold">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                            </a>
                            @if($waNumber)
                                <div class="mt-2 text-center text-xs text-gray-500">WA: {{ $waNumber }}</div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>



    {{-- ========================= --}}
    {{-- RUKO --}}
    {{-- ========================= --}}
    <section>
        <div class="flex justify-between items-end">
            <h2 class="text-xl font-bold">Sewa Ruko dan Ruang Usaha Terbaik untuk Bisnis</h2>
            <a href="{{ route('sewa',['type'=>'Ruko']) }}" class="text-blue-700 text-sm font-semibold">Lihat Semua</a>
        </div>

        @if(($businessRentals ?? collect())->count() > 0)
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach(($businessRentals ?? collect()) as $property)
                    @php
                        $img = optional($property->images->first())->path ?? 'https://source.unsplash.com/400x300/?shop';
                        $wa = $makeWhatsApp($property);
                        $waNumber = $formatPhone($property->whatsapp_phone ?? $property->agent?->phone ?? $property->user?->phone ?? null);
                    @endphp

                    <div class="bg-white rounded-2xl shadow ring-1 ring-black/5 overflow-hidden">
                        <div class="aspect-[4/3]">
                            <img src="{{ $img }}" class="w-full h-full object-cover">
                        </div>

                        <div class="p-4">
                            <div class="text-blue-700 font-bold text-sm">
                                Rp {{ number_format($property->price,0,',','.') }}
                            </div>
                            <div class="mt-1 text-sm font-semibold line-clamp-2">
                                {{ $property->title }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fa fa-map-marker mr-1"></i>{{ $property->city }}
                            </div>

                            @if($wa)
                                <a href="{{ $wa }}" target="_blank" rel="noopener"
                                    class="mt-3 flex justify-center items-center gap-2 bg-green-600 text-white h-10 rounded-xl font-semibold">
                                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                </a>
                                @if($waNumber)
                                    <div class="mt-2 text-center text-xs text-gray-500">WA: {{ $waNumber }}</div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-6 text-center py-16 bg-white rounded-2xl border border-dashed">
                <p class="text-gray-500">Belum ada properti di area ini.</p>
            </div>
        @endif
    </section>



    {{-- ========================= --}}
    {{-- VILLA --}}
    {{-- ========================= --}}
    <section>
        <div class="flex justify-between items-end">
            <h2 class="text-xl font-bold">Sewa Villa Nyaman dan Strategis untuk Liburan</h2>
            <a href="{{ route('sewa',['type'=>'Villa']) }}" class="text-blue-700 text-sm font-semibold">Lihat Semua</a>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(($villaRentals ?? collect()) as $property)
                @php
                    $img = optional($property->images->first())->path ?? 'https://source.unsplash.com/400x300/?villa';
                    $wa = $makeWhatsApp($property);
                    $waNumber = $formatPhone($property->whatsapp_phone ?? $property->agent?->phone ?? $property->user?->phone ?? null);
                @endphp

                <div class="bg-white rounded-2xl shadow ring-1 ring-black/5 overflow-hidden">
                    <div class="aspect-[4/3]">
                        <img src="{{ $img }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <div class="font-bold text-blue-700 text-sm">
                            Rp {{ number_format($property->price,0,',','.') }}
                        </div>
                        <div class="text-sm font-semibold line-clamp-2 mt-1">
                            {{ $property->title }}
                        </div>

                        @if($wa)
                            <a href="{{ $wa }}" target="_blank" rel="noopener"
                                class="mt-3 flex justify-center items-center gap-2 bg-green-600 text-white h-10 rounded-xl font-semibold">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                            </a>
                            @if($waNumber)
                                <div class="mt-2 text-center text-xs text-gray-500">WA: {{ $waNumber }}</div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>



    {{-- ========================= --}}
    {{-- INFO PROPERTI / ARTIKEL --}}
    {{-- ========================= --}}
    <section>
        <div class="flex justify-between items-end">
            <h2 class="text-xl font-bold">Info Properti</h2>
            <a href="#" class="text-blue-700 text-sm font-semibold">Selengkapnya</a>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(($articles ?? collect()) as $post)
                <a href="#" class="bg-white rounded-2xl shadow ring-1 ring-black/5 overflow-hidden">
                    <img src="{{ $post->image ?? 'https://source.unsplash.com/400x300/?real-estate' }}"
                        class="h-40 w-full object-cover">
                    <div class="p-4">
                        <div class="font-semibold line-clamp-2">{{ $post->title }}</div>
                        <p class="text-sm text-gray-500 mt-2 line-clamp-2">
                            {{ $post->excerpt ?? '' }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

</div>
</div>

@endsection
