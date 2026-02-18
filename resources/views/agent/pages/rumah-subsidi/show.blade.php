@extends('agent.layouts.app')

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
    @endphp

    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $property->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Detail Rumah Subsidi</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('agent.rumah-subsidi.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    Kembali
                </a>
                <a href="{{ route('agent.rumah-subsidi.edit', $property) }}"
                    class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-green-700">
                    <i class="fa fa-edit mr-2"></i> Edit
                </a>
                <form action="{{ route('agent.rumah-subsidi.destroy', $property) }}" method="POST"
                    onsubmit="return confirm('Hapus rumah subsidi ini?')">
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
                                <form action="{{ route('agent.rumah-subsidi.images.destroy', [$property, $image]) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?')">
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
            <div class="lg:col-span-7 space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Informasi</h3>
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Harga</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                Rp {{ $property->price ? number_format($property->price, 0, ',', '.') : '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $property->is_approved ? 'Disetujui' : 'Menunggu persetujuan' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Kota</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->city ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Provinsi</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->province ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->address ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                @if(filled($property->description))
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Deskripsi</h3>
                        <div class="prose max-w-none dark:prose-invert">
                            {!! nl2br(e($property->description)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-5 space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Spesifikasi</h3>
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Kamar Tidur</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->bedrooms ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Kamar Mandi</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->bathrooms ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Luas Tanah</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->land_area ? $property->land_area . ' m²' : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Luas Bangunan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->building_area ? $property->building_area . ' m²' : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Sertifikat</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->certificate ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Listrik</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->electricity ?? '-' }}</dd>
                        </div>
                        <div class="col-span-2">
                            <dt class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Sumber Air</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $property->water_source ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                @if($mapsEmbedSrc)
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lokasi</h3>
                            @if($mapsOpenUrl)
                                <a href="{{ $mapsOpenUrl }}" target="_blank" rel="noopener"
                                    class="text-sm font-medium text-blue-600 hover:underline">
                                    Buka Maps
                                </a>
                            @endif
                        </div>
                        <div class="mt-4 overflow-hidden rounded-lg">
                            <iframe src="{{ $mapsEmbedSrc }}" class="h-64 w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

