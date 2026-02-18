@extends('admin.layouts.app')

@section('content')
    @php
        /** @var \App\Models\Property $property */
        $images = ($property->images ?? collect())->sortBy('sort_order')->values();

        $normalizeImage = function (?string $path) {
            if (blank($path)) {
                return null;
            }
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
                return $path;
            }
            return '/storage/' . ltrim($path, '/');
        };

        $addressText = collect([$property->address, $property->city, $property->province])
            ->filter()
            ->implode(', ');

        $mapsQuery = null;
        if (filled($property->latitude) && filled($property->longitude)) {
            $mapsQuery = $property->latitude . ',' . $property->longitude;
        } elseif (filled($addressText)) {
            $mapsQuery = $addressText;
        }

        $mapsEmbedSrc = $mapsQuery ? 'https://www.google.com/maps?q=' . urlencode((string) $mapsQuery) . '&z=15&output=embed' : null;
        $mapsOpenUrl = $mapsQuery ? 'https://www.google.com/maps?q=' . urlencode((string) $mapsQuery) : null;

        $pricePeriod = $property->price_period ? '/ ' . $property->price_period : '';
    @endphp

    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $property->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Detail Properti Sewa</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.sewa.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    Kembali
                </a>
                <a href="{{ route('admin.sewa.edit', $property) }}"
                    class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-green-700">
                    <i class="fa fa-edit mr-2"></i> Edit
                </a>
                <form action="{{ route('admin.sewa.destroy', $property) }}" method="POST"
                    onsubmit="return confirm('Hapus properti sewa ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-red-700">
                        <i class="fa fa-trash mr-2"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Images Gallery --}}
        @if($images->count() > 0)
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Galeri Foto</h3>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-6">
                    @foreach($images as $image)
                        @php
                            $imgSrc = $normalizeImage($image->path ?? null);
                        @endphp
                        <div class="group relative aspect-square overflow-hidden rounded-lg">
                            <img src="{{ $imgSrc }}" alt="{{ $property->title }}" class="h-full w-full object-cover" loading="lazy">
                            @if($image->is_primary)
                                <span class="absolute bottom-2 left-2 rounded bg-green-600 px-2 py-1 text-xs text-white">Primary</span>
                            @endif
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity">
                                <form action="{{ route('admin.sewa.images.destroy', [$property, $image]) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full bg-red-500 p-2 text-white hover:bg-red-600">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
            {{-- Main --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Informasi Utama</h3>
                    <dl class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Harga</dt>
                            <dd class="text-sm font-semibold text-green-700 dark:text-green-400">
                                Rp {{ number_format((float) ($property->price ?? 0), 0, ',', '.') }} {{ $pricePeriod }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Tipe Properti</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->type ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Status Publish</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                @if($property->is_published)
                                    <span class="rounded-full bg-green-50 px-2 py-0.5 text-green-600 dark:bg-green-500/10 dark:text-green-400">Dipublikasikan</span>
                                @else
                                    <span class="rounded-full bg-yellow-50 px-2 py-0.5 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-300">Draft</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Kota</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->city ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Provinsi</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->province ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Kode Pos</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->postal_code ?: '-' }}</dd>
                        </div>

                        <div class="md:col-span-3">
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Alamat</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->address ?: '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Spesifikasi</h3>
                    <dl class="grid grid-cols-2 gap-4 md:grid-cols-4">
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Kamar Tidur</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->bedrooms ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Kamar Mandi</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->bathrooms ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Luas Tanah</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->land_area ? $property->land_area . ' m²' : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Luas Bangunan</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->building_area ? $property->building_area . ' m²' : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Sertifikat</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ strtoupper($property->certificate) ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Furnishing</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                @switch($property->furnishing)
                                    @case('unfurnished')
                                        Tidak Berperalatan
                                        @break
                                    @case('semi')
                                        Semi Berperalatan
                                        @break
                                    @case('furnished')
                                        Berperalatan Lengkap
                                        @break
                                    @default
                                        -
                                                        @endswitch
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Sumber Air</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                @switch($property->water_source)
                                    @case('pdam')
                                        PDAM
                                        @break
                                    @case('well')
                                        Sumur
                                        @break
                                    @case('jetpump')
                                        Jetpump
                                        @break
                                    @default
                                        -
                                                        @endswitch
                            </dd>
                        </div>
                    </dl>
                </div>

                @if(($property->features ?? collect())->count() > 0)
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Fasilitas</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($property->features as $feature)
                                <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-semibold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                    @if(!empty($feature->icon))
                                        <i class="{{ $feature->icon }}"></i>
                                    @else
                                        <i class="fa fa-check"></i>
                                    @endif
                                    {{ $feature->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Deskripsi</h3>
                    <div class="prose dark:prose-invert max-w-none">
                        <p class="whitespace-pre-wrap text-sm text-gray-700 dark:text-gray-300">{{ $property->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>

                @if($mapsEmbedSrc)
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                        <div class="flex items-center justify-between gap-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lokasi (Google Maps)</h3>
                            @if($mapsOpenUrl)
                                <a href="{{ $mapsOpenUrl }}" target="_blank" rel="noopener"
                                    class="text-sm font-semibold text-blue-600 hover:underline">
                                    Buka Maps
                                </a>
                            @endif
                        </div>
                        <div class="mt-4 overflow-hidden rounded-xl border border-gray-100 dark:border-gray-800">
                            <iframe src="{{ $mapsEmbedSrc }}" class="h-72 w-full" loading="lazy"></iframe>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Side --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Status</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Kategori Listing</span>
                            <span class="font-semibold text-gray-900 dark:text-white">Sewa</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Unggulan</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $property->is_featured ? 'Ya' : 'Tidak' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Disetujui</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $property->is_approved ? 'Ya' : 'Tidak' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Dibuat</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ optional($property->created_at)->format('d M Y H:i') ?: '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Diperbarui</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ optional($property->updated_at)->format('d M Y H:i') ?: '-' }}</span>
                        </div>
                    </div>
                </div>

                @if($property->user || $property->agent)
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Agen / Penjual</h3>
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-800">
                                @if($property->agent?->photo)
                                    <img src="{{ $property->agent->photo }}" alt="{{ $property->agent->name }}" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $property->agent?->name ?? $property->user?->name ?? '-' }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $property->agent?->phone ?? $property->user?->phone ?? '-' }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $property->agent?->email ?? $property->user?->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
