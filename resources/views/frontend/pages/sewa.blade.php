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

    $listingMode = (bool)($listingMode ?? false);
    $activeShortcut = $activeShortcut ?? null;
    $forcedType = $forcedType ?? null;
    $forcedPeriod = $forcedPeriod ?? null;
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
                    Temukan rumah, kost, villa, dan ruang usaha terbaik dengan mudah.
                </p>
            </div>

            {{-- SEARCH --}}
            <div class="mt-8 max-w-4xl mb-6">
                <form action="{{ url()->current() }}" method="GET"
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
                            @if(filled($forcedType))
                                <select disabled
                                    class="h-12 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm text-gray-700 focus:ring-2 focus:ring-blue-600">
                                    <option>{{ $forcedType }}</option>
                                </select>
                            @else
                                <select name="type"
                                    class="h-12 w-full rounded-xl border border-gray-200 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                                    <option value="">Tipe</option>
                                    @foreach(($typeOptions ?? collect()) as $t)
                                        <option value="{{ $t }}" @selected(request('type')==$t)>{{ $t }}</option>
                                    @endforeach
                                </select>
                            @endif
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
                        ['label' => 'Rumah', 'icon' => 'fa-house', 'shortcut' => 'rumah'],
                        ['label' => 'Kost', 'icon' => 'fa-building', 'shortcut' => 'kost'],
                        ['label' => 'Villa', 'icon' => 'fa-umbrella-beach', 'shortcut' => 'villa'],
                        ['label' => 'Ruko', 'icon' => 'fa-store', 'shortcut' => 'ruko'],
                        ['label' => 'Tanah', 'icon' => 'fa-mountain', 'shortcut' => 'tanah'],
                        ['label' => 'Bulanan', 'icon' => 'fa-calendar', 'shortcut' => 'bulanan'],
                        ['label' => 'Tahunan', 'icon' => 'fa-calendar-check', 'shortcut' => 'tahunan'],
                        ['label' => 'Bantuan', 'icon' => 'fa-headset', 'shortcut' => 'bantuan'],
                    ];
                @endphp

                @foreach($shortcuts as $s)
                    @php
                        $href = route('sewa.shortcut', $s['shortcut']);
                        if (count($baseParams)) {
                            $href .= '?' . http_build_query($baseParams);
                        }
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

    <div class="max-w-[1200px] mx-auto px-4 py-10 {{ $listingMode ? '' : 'space-y-14' }}">

    @if($listingMode)
        <div class="grid gap-6 lg:grid-cols-12">
            <aside class="lg:col-span-3">
                <form action="{{ url()->current() }}" method="GET" class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-extrabold text-gray-900">Filter</h2>
                        @php
                            $baseClearHref = $activeShortcut
                                ? route('sewa.shortcut', $activeShortcut)
                                : route('sewa');
                        @endphp
                        <a href="{{ $baseClearHref }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800">Reset</a>
                    </div>

                    <div class="mt-4 space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-700">Keyword</label>
                            <input name="q" value="{{ request('q') }}" placeholder="Lokasi / keyword"
                                class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm focus:ring-2 focus:ring-blue-600">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-700">Kota</label>
                            <select name="city"
                                class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                                <option value="">Semua Kota</option>
                                @foreach(($cityOptions ?? collect()) as $city)
                                    <option value="{{ $city }}" @selected(request('city')==$city)>{{ $city }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-700">Tipe</label>
                            @if(filled($forcedType))
                                <select disabled
                                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-100 px-3 text-sm text-gray-700">
                                    <option>{{ $forcedType }}</option>
                                </select>
                            @else
                                <select name="type"
                                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                                    <option value="">Semua Tipe</option>
                                    @foreach(($typeOptions ?? collect()) as $t)
                                        <option value="{{ $t }}" @selected(request('type')==$t)>{{ $t }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-700">Periode</label>
                            @if(filled($forcedPeriod))
                                <input type="hidden" name="period" value="{{ $forcedPeriod }}">
                                <select disabled
                                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-100 px-3 text-sm text-gray-700">
                                    <option>{{ $forcedPeriod === 'bulan' ? 'Bulanan' : 'Tahunan' }}</option>
                                </select>
                            @else
                                <select name="period"
                                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                                    <option value="">Semua</option>
                                    <option value="bulan" @selected(request('period')==='bulan')>Bulanan</option>
                                    <option value="tahun" @selected(request('period')==='tahun')>Tahunan</option>
                                </select>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-semibold text-gray-700">Min Harga</label>
                                <input name="min_price" type="number" inputmode="numeric" value="{{ request('min_price') }}"
                                    placeholder="0"
                                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-700">Max Harga</label>
                                <input name="max_price" type="number" inputmode="numeric" value="{{ request('max_price') }}"
                                    placeholder="0"
                                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-semibold text-gray-700">K. Tidur</label>
                                <input name="bedrooms" type="number" min="0" inputmode="numeric" value="{{ request('bedrooms') }}"
                                    placeholder="0"
                                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-gray-700">K. Mandi</label>
                                <input name="bathrooms" type="number" min="0" inputmode="numeric" value="{{ request('bathrooms') }}"
                                    placeholder="0"
                                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                            </div>
                        </div>

                        <button class="h-11 w-full rounded-xl bg-blue-700 text-sm font-semibold text-white hover:bg-blue-800">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </aside>

            <main class="lg:col-span-9">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-extrabold text-gray-900">
                            {{ filled($forcedType) ? 'Sewa ' . $forcedType : 'Properti Disewa' }}
                            @if(filled($forcedPeriod))
                                <span class="text-gray-500 font-semibold">({{ $forcedPeriod === 'bulan' ? 'Bulanan' : 'Tahunan' }})</span>
                            @endif
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Menampilkan {{ ($properties ?? null)?->total() ?? 0 }} properti.
                        </p>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse(($properties ?? collect()) as $property)
                        @include('frontend.components.property-card', ['property' => $property, 'wrapLink' => false, 'showWhatsApp' => true, 'showPricePeriod' => true])
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed bg-white p-10 text-center text-sm text-gray-500">
                            Tidak ada properti yang cocok dengan filter ini.
                        </div>
                    @endforelse
                </div>

                @if(($properties ?? null) && method_exists($properties, 'links'))
                    <div class="mt-8">
                        {{ $properties->onEachSide(1)->links() }}
                    </div>
                @endif
            </main>
        </div>
    @else

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
                @include('frontend.components.property-card', ['property' => $property, 'wrapLink' => false, 'showWhatsApp' => true, 'showPricePeriod' => true])
            @endforeach
        </div>
    </section>



    {{-- ========================= --}}
    {{-- KOST --}}
    {{-- ========================= --}}
    <section class="rounded-3xl p-6 bg-gradient-to-r from-blue-800 to-indigo-700 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">Sewa Kost</h2>
                <p class="text-sm text-white/80">Hunian praktis dekat pusat kota.</p>
            </div>
            <a href="{{ route('sewa.shortcut','kost') }}"
                class="bg-white text-blue-800 px-4 py-2 rounded-xl text-sm font-semibold">
                Lihat Semua
            </a>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(($kostRentals ?? collect())->take(8) as $property)
                @include('frontend.components.property-card', ['property' => $property, 'wrapLink' => false, 'showWhatsApp' => true, 'showPricePeriod' => true])
            @endforeach
        </div>
    </section>



    {{-- ========================= --}}
    {{-- RUKO --}}
    {{-- ========================= --}}
    <section>
        <div class="flex justify-between items-end">
            <h2 class="text-xl font-bold">Sewa Ruko dan Ruang Usaha Terbaik untuk Bisnis</h2>
            <a href="{{ route('sewa.shortcut','ruko') }}" class="text-blue-700 text-sm font-semibold">Lihat Semua</a>
        </div>

        @if(($businessRentals ?? collect())->count() > 0)
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach(($businessRentals ?? collect()) as $property)
                    @include('frontend.components.property-card', ['property' => $property, 'wrapLink' => false, 'showWhatsApp' => true, 'showPricePeriod' => true])
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
            <a href="{{ route('sewa.shortcut','villa') }}" class="text-blue-700 text-sm font-semibold">Lihat Semua</a>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(($villaRentals ?? collect()) as $property)
                @include('frontend.components.property-card', ['property' => $property, 'wrapLink' => false, 'showWhatsApp' => true, 'showPricePeriod' => true])
            @endforeach
        </div>
    </section>



    {{-- ========================= --}}
    {{-- INFO PROPERTI / ARTIKEL --}}
    {{-- ========================= --}}
    <section>
        <div class="flex justify-between items-end">
            <h2 class="text-xl font-bold">Info Properti</h2>
            <a href="{{ route('articles') }}" class="text-blue-700 text-sm font-semibold">Selengkapnya</a>
        </div>

        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach(($articles ?? collect()) as $post)
                <a href="{{ route('articles.show', $post->slug) }}" class="bg-white rounded-2xl shadow ring-1 ring-black/5 overflow-hidden hover:shadow-md transition">
                    <img src="{{ $post->image ? Storage::url($post->image) : 'https://source.unsplash.com/400x300/?real-estate&sig=' . $post->id }}"
                        class="h-40 w-full object-cover" alt="{{ $post->title }}">
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

    @endif

</div>
</div>

@endsection
