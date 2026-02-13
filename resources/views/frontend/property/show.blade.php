@extends('frontend.layouts.app')

@section('content')
    @php
        $fallbackImages = collect([
            '/assets/admin/images/product/product-01.jpg',
            '/assets/admin/images/product/product-02.jpg',
            '/assets/admin/images/product/product-03.jpg',
            '/assets/admin/images/product/product-04.jpg',
        ]);

        $images = $property->images->sortBy('sort_order')->values();
        if ($images->isEmpty()) {
            $images = $fallbackImages->map(fn ($path) => (object) ['path' => $path, 'alt' => null, 'is_primary' => false]);
        }

        $mainImage = $images->firstWhere('is_primary', true) ?? $images->first();

        $priceText = $property->price
            ? 'Rp ' . number_format((float) $property->price, 0, ',', '.')
            : 'Hubungi Kami';

        $pricePeriod = $property->price_period ? '/' . $property->price_period : null;

        $addressText = collect([
            $property->address,
            $property->city,
            $property->province,
        ])->filter()->implode(', ');

        $mapsQuery = null;
        if (filled($property->latitude) && filled($property->longitude)) {
            $mapsQuery = $property->latitude . ',' . $property->longitude;
        } elseif (filled($addressText)) {
            $mapsQuery = $addressText;
        }

        $mapsEmbedSrc = $mapsQuery
            ? 'https://www.google.com/maps?q=' . urlencode((string) $mapsQuery) . '&z=15&output=embed'
            : null;
        $mapsOpenUrl = $mapsQuery
            ? 'https://www.google.com/maps?q=' . urlencode((string) $mapsQuery)
            : null;

        $formatValue = function (string $field, mixed $value): mixed {
            if (!filled($value)) {
                return null;
            }

            $raw = is_string($value) ? trim($value) : $value;

            $labelize = function (string $text): string {
                $text = str_replace(['_', '-'], ' ', $text);
                $text = preg_replace('/\s+/', ' ', $text) ?? $text;
                return ucwords(strtolower($text));
            };

            return match ($field) {
                'certificate' => strtoupper((string) $raw),
                'water_source' => match (strtolower((string) $raw)) {
                    'pdam' => 'PDAM',
                    'well' => 'Sumur',
                    'jetpump' => 'Jetpump',
                    default => $labelize((string) $raw),
                },
                'furnishing' => match (strtolower((string) $raw)) {
                    'unfurnished' => 'Unfurnished',
                    'semi' => 'Semi Furnished',
                    'furnished' => 'Furnished',
                    default => $labelize((string) $raw),
                },
                'orientation' => match (strtolower((string) $raw)) {
                    'north' => 'Utara',
                    'south' => 'Selatan',
                    'east' => 'Timur',
                    'west' => 'Barat',
                    default => $labelize((string) $raw),
                },
                default => $raw,
            };
        };

        $specPairs = collect([
            ['label' => 'Tipe', 'value' => $property->type],
            ['label' => 'Status', 'value' => $property->status ? ucwords($property->status) : null],
            ['label' => 'Kamar Tidur', 'value' => $property->bedrooms ? $property->bedrooms . ' KT' : null],
            ['label' => 'Kamar Mandi', 'value' => $property->bathrooms ? $property->bathrooms . ' KM' : null],
            ['label' => 'Luas Tanah', 'value' => $property->land_area ? $property->land_area . ' m²' : null],
            ['label' => 'Luas Bangunan', 'value' => $property->building_area ? $property->building_area . ' m²' : null],
            ['label' => 'Sertifikat', 'value' => $formatValue('certificate', $property->certificate)],
            ['label' => 'Listrik', 'value' => $property->electricity],
            ['label' => 'Sumber Air', 'value' => $formatValue('water_source', $property->water_source)],
            ['label' => 'Furnishing', 'value' => $formatValue('furnishing', $property->furnishing)],
            ['label' => 'Hadap', 'value' => $formatValue('orientation', $property->orientation)],
            ['label' => 'Tahun Dibangun', 'value' => $property->year_built],
        ])->filter(fn ($row) => filled($row['value']))->values();

        $whatsAppPhone = preg_replace('/\\D+/', '', (string) ($property->agent?->phone ?? ''));
        $whatsAppLink = $whatsAppPhone ? "https://wa.me/{$whatsAppPhone}" : null;

        $agentPhoto = $property->agent?->photo ?: null;
    @endphp

    <div class="bg-gray-50">
        <div class="max-w-[1200px] mx-auto px-4 py-6">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <!-- Main -->
                <div class="lg:col-span-8">
                    <!-- Gallery -->
                    <div class="rounded-2xl bg-white shadow-sm overflow-hidden">
                        <div class="grid grid-cols-1 gap-3 p-3 md:grid-cols-12">
                            <div class="md:col-span-9">
                                <div class="relative h-[240px] overflow-hidden rounded-xl bg-gray-100 sm:h-[360px] md:h-[420px] lg:h-[460px]">
                                    <img id="property-main-image"
                                        src="{{ $mainImage->path }}"
                                        alt="{{ $mainImage->alt ?? $property->title }}"
                                        class="h-full w-full object-cover">

                                    <button type="button" id="property-gallery-prev" @disabled($images->count() <= 1)
                                        class="absolute left-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-white/90 shadow flex items-center justify-center text-gray-700 hover:bg-white disabled:cursor-not-allowed disabled:opacity-50"
                                        aria-label="Sebelumnya">
                                        <i class="fa fa-chevron-left"></i>
                                    </button>
                                    <button type="button" id="property-gallery-next" @disabled($images->count() <= 1)
                                        class="absolute right-3 top-1/2 -translate-y-1/2 h-10 w-10 rounded-full bg-white/90 shadow flex items-center justify-center text-gray-700 hover:bg-white disabled:cursor-not-allowed disabled:opacity-50"
                                        aria-label="Berikutnya">
                                        <i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="md:col-span-3">
                                <div class="grid grid-cols-4 gap-2 md:grid-cols-1 md:h-[420px] md:overflow-auto md:pr-1 lg:h-[460px]">
                                    @foreach ($images->take(5) as $idx => $img)
                                        <button type="button"
                                            class="property-thumb aspect-[4/3] overflow-hidden rounded-xl bg-gray-100 ring-2 ring-offset-2 ring-offset-white {{ $img->path === $mainImage->path ? 'ring-blue-600' : 'ring-transparent hover:ring-blue-300' }} md:aspect-auto md:h-24 lg:h-[100px]"
                                            data-src="{{ $img->path }}"
                                            data-index="{{ $idx }}"
                                            aria-label="Thumbnail {{ $idx + 1 }}">
                                            <img src="{{ $img->path }}" alt="Thumbnail" class="h-full w-full object-cover">
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="mt-4 rounded-2xl bg-white p-5 shadow-sm">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    @if ($property->category?->name)
                                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                                            {{ $property->category->name }}
                                        </span>
                                    @endif
                                    @if ($property->status)
                                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                            {{ ucwords($property->status) }}
                                        </span>
                                    @endif
                                </div>

                                <h1 class="mt-2 text-xl font-bold text-gray-900 md:text-2xl">
                                    {{ $property->title }}
                                </h1>

                                @if ($addressText)
                                    <p class="mt-1 text-sm text-gray-600">
                                        <i class="fa fa-map-marker mr-1"></i>
                                        {{ $addressText }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex flex-col items-start sm:items-end">
                                <div class="text-lg font-bold text-blue-600 md:text-xl">
                                    {{ $priceText }}@if ($pricePeriod)<span class="text-sm font-semibold text-blue-600">{{ $pricePeriod }}</span>@endif
                                </div>
                                <button type="button"
                                    class="mt-2 inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fa fa-flag"></i>
                                    Laporkan
                                </button>
                            </div>
                        </div>

                        @if ($property->features && $property->features->count() > 0)
                            <div class="mt-4">
                                <h2 class="text-sm font-semibold text-gray-900">Overview</h2>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($property->features->take(12) as $feature)
                                        <span class="rounded-full border border-gray-200 bg-white px-3 py-1 text-xs text-gray-700">
                                            {{ $feature->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="mt-4 rounded-2xl bg-white p-5 shadow-sm">
                        <h2 class="text-base font-semibold text-gray-900">Informasi Properti</h2>
                        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            @foreach ($specPairs as $row)
                                <div class="rounded-xl border border-gray-100 p-4">
                                    <p class="text-xs text-gray-500">{{ $row['label'] }}</p>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $row['value'] }}</p>
                                </div>
                            @endforeach
                        </div>

                        @if ($property->specifications && $property->specifications->count() > 0)
                            <div class="mt-5">
                                <h3 class="text-sm font-semibold text-gray-900">Spesifikasi Tambahan</h3>
                                <div class="mt-3 overflow-hidden rounded-xl border border-gray-100">
                                    <div class="divide-y divide-gray-100">
                                        @foreach ($property->specifications as $spec)
                                            <div class="flex items-center justify-between gap-4 px-4 py-3 text-sm">
                                                <span class="text-gray-600">{{ $spec->label }}</span>
                                                <span class="font-medium text-gray-900">{{ $spec->value }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mt-4 rounded-2xl bg-white p-5 shadow-sm">
                        <h2 class="text-base font-semibold text-gray-900">Deskripsi</h2>
                        <div class="prose prose-sm mt-3 max-w-none text-gray-700">
                            {!! nl2br(e($property->description ?? 'Belum ada deskripsi untuk properti ini.')) !!}
                        </div>
                    </div>

                    <!-- Nearby -->
                    @if ($property->nearby && $property->nearby->count() > 0)
                        <div class="mt-4 rounded-2xl bg-white p-5 shadow-sm">
                            <h2 class="text-base font-semibold text-gray-900">Sekitar Properti</h2>
                            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                @foreach ($property->nearby as $n)
                                    <div class="flex items-center justify-between rounded-xl border border-gray-100 p-4 text-sm">
                                        <span class="text-gray-700">{{ $n->label }}</span>
                                        <span class="font-semibold text-gray-900">{{ $n->distance }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Location -->
                    <div class="mt-4 rounded-2xl bg-white p-5 shadow-sm">
                        <h2 class="text-base font-semibold text-gray-900">Lokasi Properti</h2>
                        @if($mapsEmbedSrc)
                            <div class="mt-3 overflow-hidden rounded-2xl border border-gray-100 bg-white">
                                <div class="aspect-[16/9] bg-gray-100">
                                    <iframe
                                        src="{{ $mapsEmbedSrc }}"
                                        class="h-full w-full"
                                        style="border:0;"
                                        allowfullscreen=""
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                                <div class="flex flex-col gap-2 p-4 sm:flex-row sm:items-center sm:justify-between">
                                    <p class="text-sm text-gray-600">
                                        <i class="fa fa-map-marker mr-1"></i>
                                        {{ $mapsQuery }}
                                    </p>
                                    <a href="{{ $mapsOpenUrl }}" target="_blank" rel="noopener"
                                        class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                        Buka Google Maps
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="mt-3 rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-6 text-center text-sm text-gray-500">
                                Lokasi belum tersedia untuk properti ini.
                            </div>
                        @endif
                    </div>

                    <!-- Recommendations -->
                    @if(isset($relatedProperties) && $relatedProperties->count() > 0)
                        <div class="mt-8">
                            <div class="flex items-center justify-between">
                                <h2 class="text-base font-semibold text-gray-900">Rekomendasi Properti</h2>
                                <a href="{{ route('properties') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat lainnya</a>
                            </div>

                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($relatedProperties as $item)
                                    @include('frontend.components.property-card', ['property' => $item])
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-4">
                    <div class="sticky top-6 space-y-4">
                        <div class="rounded-2xl bg-white p-5 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-12 overflow-hidden rounded-full bg-gray-200">
                                    @if ($agentPhoto)
                                        <img src="{{ $agentPhoto }}" alt="{{ $property->agent?->name }}" class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $property->agent?->name ?? 'Agen Properti' }}</p>
                                    <p class="text-xs text-gray-500">Agen</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center gap-2">
                                @if($property->agent?->phone)
                                    <a href="tel:{{ $whatsAppPhone ?: $property->agent->phone }}"
                                        class="flex-1 rounded-lg border border-gray-200 px-3 py-2 text-center text-sm text-gray-700 hover:bg-gray-50">
                                        Telepon
                                    </a>
                                @else
                                    <button type="button"
                                        class="flex-1 cursor-not-allowed rounded-lg border border-gray-200 px-3 py-2 text-center text-sm text-gray-400">
                                        Telepon
                                    </button>
                                @endif

                                @if($whatsAppLink)
                                    <a href="{{ $whatsAppLink }}"
                                        class="flex-1 rounded-lg bg-green-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-green-600">
                                        WhatsApp
                                    </a>
                                @else
                                    <button type="button"
                                        class="flex-1 cursor-not-allowed rounded-lg bg-green-200 px-3 py-2 text-center text-sm font-semibold text-white">
                                        WhatsApp
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="rounded-2xl bg-white p-4 shadow-sm">
                            <p class="text-sm font-semibold text-gray-900">Simulasi Cicilan KPR</p>
                            <div class="mt-3 space-y-2 text-sm text-gray-600">
                                <div class="flex items-center justify-between">
                                    <span>Harga Properti</span>
                                    <span class="font-semibold text-gray-900">{{ $priceText }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Uang Muka</span>
                                    <span class="font-semibold text-gray-900">20%</span>
                                </div>
                            </div>
                            <div class="mt-4 rounded-lg bg-blue-50 p-3 text-xs text-blue-700">
                                Ini simulasi sederhana. Gunakan halaman kalkulator untuk hasil lebih akurat.
                            </div>
                            <a href="{{ route('calculator') }}"
                                class="mt-4 inline-flex w-full items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                Hitung di Kalkulator
                            </a>
                        </div>

                        <div class="rounded-2xl bg-white p-3 shadow-sm">
                            <div class="h-40 rounded-xl bg-gray-100"></div>
                            <p class="mt-2 text-xs text-gray-500">Iklan/Promosi</p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainImage = document.getElementById('property-main-image');
            const thumbs = Array.from(document.querySelectorAll('.property-thumb'));
            const prevBtn = document.getElementById('property-gallery-prev');
            const nextBtn = document.getElementById('property-gallery-next');

            if (!mainImage || thumbs.length === 0) return;

            let currentIndex = Math.max(0, thumbs.findIndex(t => t.dataset.src === mainImage.getAttribute('src')));

            function setActive(index) {
                const bounded = (index + thumbs.length) % thumbs.length;
                currentIndex = bounded;

                const src = thumbs[bounded].dataset.src;
                if (src) mainImage.setAttribute('src', src);

                thumbs.forEach((t, i) => {
                    t.classList.toggle('ring-blue-600', i === bounded);
                    t.classList.toggle('ring-transparent', i !== bounded);
                });
            }

            thumbs.forEach((t, i) => {
                t.addEventListener('click', () => setActive(i));
            });

            if (prevBtn) prevBtn.addEventListener('click', () => setActive(currentIndex - 1));
            if (nextBtn) nextBtn.addEventListener('click', () => setActive(currentIndex + 1));
        });
    </script>
@endsection
