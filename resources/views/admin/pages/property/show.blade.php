@extends('admin.layouts.app')

@section('content')
    @php
        /** @var \App\Models\Property $property */
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

        $frontendUrl = route('property.show', $property->slug ?: $property->getKey());
    @endphp

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $property->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Property Detail</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.properties.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    Kembali
                </a>
                <a href="{{ $frontendUrl }}" target="_blank" rel="noopener"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    <i class="fa fa-arrow-up-right-from-square mr-2"></i> Lihat di User
                </a>
                @if(!$property->is_approved)
                    <form action="{{ route('admin.properties.approve', $property) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-green-700">
                            Approve
                        </button>
                    </form>
                    <form action="{{ route('admin.properties.reject', $property) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-red-700">
                            Reject
                        </button>
                    </form>
                @else
                    <span
                        class="inline-flex items-center rounded-lg bg-green-50 px-3 py-2 text-sm font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-400">
                        Approved
                    </span>
                @endif
                <a href="{{ route('admin.properties.edit', $property) }}"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">Edit</a>
            </div>
        </div>

        <!-- Images Gallery -->
        @if($property->images->count() > 0)
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Galeri Foto</h3>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-6">
                @foreach($property->images->sortBy('sort_order') as $image)
                    <div class="relative aspect-square overflow-hidden rounded-lg group">
                        <img src="{{ $normalizeImage($image->path ?? null) }}" alt="{{ $property->title }}" class="h-full w-full object-cover" loading="lazy">
                        @if($image->is_primary)
                            <span class="absolute bottom-2 left-2 rounded bg-brand-500 px-2 py-1 text-xs text-white">Primary</span>
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity">
                            <form action="{{ route('admin.properties.images.destroy', [$property, $image]) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
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

        <!-- Basic Info -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Informasi Utama</h3>
            <dl class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Tipe Properti</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ ucwords($property->type) ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                        @if($property->status == 'dijual')
                            <span class="rounded-full bg-green-50 px-2 py-0.5 text-green-600 dark:bg-green-500/10 dark:text-green-400">Dijual</span>
                        @elseif($property->status == 'disewakan')
                            <span class="rounded-full bg-blue-50 px-2 py-0.5 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">Disewakan</span>
                        @else
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 dark:bg-white/10">-</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Featured</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                        @if($property->is_featured)
                            <span class="rounded-full bg-yellow-50 px-2 py-0.5 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400">Yes</span>
                        @else
                            <span class="text-gray-500">No</span>
                        @endif
                    </dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Kategori Home</dt>
                    <dd class="mt-1 flex flex-wrap gap-2 text-sm font-medium text-gray-900 dark:text-white">
                        @forelse(($property->listingCategories ?? collect())->sortBy('sort_order') as $cat)
                            <span class="rounded-full bg-brand-500/10 px-2 py-0.5 text-brand-600 dark:text-brand-300">{{ $cat->name }}</span>
                        @empty
                            <span class="text-gray-500">-</span>
                        @endforelse
                    </dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Fasilitas</dt>
                    <dd class="mt-1 flex flex-wrap gap-2 text-sm font-medium text-gray-900 dark:text-white">
                        @forelse(($property->features ?? collect()) as $feature)
                            <span class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-semibold text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                @if(!empty($feature->icon))
                                    <i class="{{ $feature->icon }}"></i>
                                @else
                                    <i class="fa fa-check"></i>
                                @endif
                                {{ $feature->name }}
                            </span>
                        @empty
                            <span class="text-gray-500">-</span>
                        @endforelse
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Approval</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                        @if($property->is_approved)
                            <span class="rounded-full bg-green-50 px-2 py-0.5 text-green-600 dark:bg-green-500/10 dark:text-green-400">Approved</span>
                        @else
                            <span class="rounded-full bg-yellow-50 px-2 py-0.5 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-300">Pending</span>
                        @endif
                    </dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Harga</dt>
                    <dd class="text-xl font-bold text-brand-500">
                        {{ $property->price ? 'Rp ' . number_format($property->price, 0, ',', '.') : 'Hubungi Kami' }}
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Location -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lokasi</h3>
                @if($mapsOpenUrl)
                    <a href="{{ $mapsOpenUrl }}" target="_blank" rel="noopener" class="text-sm font-semibold text-brand-500 hover:underline">
                        Buka Maps
                    </a>
                @endif
            </div>
            <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Alamat</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $addressText ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Kota</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->city ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Provinsi</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->province ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Kode Pos</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->postal_code ?? '-' }}</dd>
                </div>
            </dl>

            @if($mapsEmbedSrc)
                <div class="mt-5 overflow-hidden rounded-xl border border-gray-100 dark:border-gray-800">
                    <iframe src="{{ $mapsEmbedSrc }}" class="h-72 w-full" loading="lazy"></iframe>
                </div>
            @endif
        </div>

        <!-- Specifications -->
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
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Lantai</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->floors ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Carport</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->carports ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Garasi</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->garages ?? '-' }}</dd>
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
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Tahun Dibangun</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->year_built ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Additional Details -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Detail Tambahan</h3>
            <dl class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Tipe Properti</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ ucwords($property->type) ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Sertifikat</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ strtoupper($property->certificate) ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Listrik</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->electricity ? $property->electricity . ' Watt' : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Sumber Air</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ strtoupper($property->water_source) ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Furnishing</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ ucwords($property->furnishing) ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Orientasi</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ ucwords($property->orientation) ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ strtoupper($property->status) ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Description -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Deskripsi</h3>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $property->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>

        <!-- Agent/User Info -->
        @if($property->user || $property->agent)
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Agen / Penjual</h3>
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-full bg-gray-200 overflow-hidden">
                    @if($property->user?->avatar)
                        <img src="{{ $property->user->avatar }}" alt="{{ $property->user->name }}" class="h-full w-full object-cover">
                    @elseif($property->agent?->avatar)
                        <img src="{{ $property->agent->avatar }}" alt="{{ $property->agent->name }}" class="h-full w-full object-cover">
                    @endif
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $property->user?->name ?? $property->agent?->name ?? '-' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $property->user?->email ?? $property->agent?->email ?? '-' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $property->user?->phone ?? $property->agent?->phone ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Nearby Places -->
        @if($property->nearby->count() > 0)
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Tempat Terdekat</h3>
            <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach($property->nearby as $nearby)
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">{{ $nearby->type }}</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $nearby->name }} ({{ $nearby->distance }} km)</dd>
                </div>
                @endforeach
            </dl>
        </div>
        @endif

        <!-- Videos -->
        @if($property->videos->count() > 0)
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Video</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach($property->videos as $video)
                <div class="aspect-video overflow-hidden rounded-lg">
                    @if($video->type === 'youtube')
                        <iframe src="https://www.youtube.com/embed/{{ $video->url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                    @else
                        <video src="{{ $video->url }}" class="w-full h-full" controls></video>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Documents -->
        @if($property->documents->count() > 0)
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Dokumen</h3>
            <ul class="space-y-2">
                @foreach($property->documents as $document)
                <li>
                    <a href="{{ $document->path }}" target="_blank" class="flex items-center gap-2 text-sm text-brand-500 hover:underline">
                        <i class="fa fa-file"></i>
                        {{ $document->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Projects -->
        @if($property->projects->count() > 0)
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Proyek</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($property->projects as $project)
                    <span class="rounded-full bg-blue-100 px-3 py-1 text-sm text-blue-700 dark:bg-blue-500/20 dark:text-blue-400">
                        {{ $project->name }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection

