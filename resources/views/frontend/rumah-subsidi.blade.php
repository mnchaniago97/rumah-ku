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
    @endphp

    <div class="bg-gray-50 py-8">
        <div class="mx-auto max-w-[1200px] px-4">
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-bold text-gray-900">Rumah Subsidi</h1>
                <p class="mt-2 text-gray-600">Temukan rumah subsidi dengan harga terjangkau dan fasilitas lengkap</p>
            </div>

            {{-- Featured Rumah Subsidi --}}
            <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                @forelse($properties->take(4) as $property)
                    @php
                        $images = ($property->images ?? collect())->sortBy('sort_order')->values();
                        $primaryImage = $images->firstWhere('is_primary', true) ?? $images->first();
                        $imageSrc = $normalizeImage($primaryImage?->path) ?: $fallbackImages->random();

                        $addressText = collect([$property->address, $property->city, $property->province])->filter()->implode(', ');
                    @endphp

                    <a href="{{ route('property.show', $property->slug ?? $property->id) }}"
                        class="block overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">
                        <div class="relative aspect-[16/9] bg-gray-200">
                            <img src="{{ $imageSrc }}" alt="{{ $property->title }}"
                                class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                            <span class="absolute left-4 top-4 rounded-full bg-green-600 px-3 py-1 text-xs font-medium text-white">
                                Rumah Subsidi
                            </span>
                        </div>

                        <div class="p-5">
                            <h2 class="mb-2 line-clamp-1 text-xl font-bold text-gray-900">{{ $property->title }}</h2>
                            <p class="mb-3 line-clamp-1 text-sm text-gray-500">
                                <i class="fa fa-map-marker mr-1"></i>
                                {{ $addressText ?: 'Lokasi belum diisi' }}
                            </p>

                            <div class="mb-4 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-600">
                                @if($property->bedrooms)
                                    <span><i class="fa fa-bed mr-1"></i> {{ $property->bedrooms }} KT</span>
                                @endif
                                @if($property->bathrooms)
                                    <span><i class="fa fa-shower mr-1"></i> {{ $property->bathrooms }} KM</span>
                                @endif
                                @if($property->land_area)
                                    <span><i class="fa fa-expand mr-1"></i> {{ number_format((float) $property->land_area) }} m²</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">Subsidi</p>
                                    <p class="text-lg font-bold text-blue-600">
                                        Rp {{ number_format((float) ($property->price ?? 0), 0, ',', '.') }}
                                    </p>
                                </div>
                                <span class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white">
                                    Lihat Detail <i class="fa fa-arrow-right text-xs"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-2 py-12 text-center">
                        <i class="fa fa-home mb-4 text-5xl text-gray-300"></i>
                        <p class="text-gray-500">Belum ada rumah subsidi yang tersedia.</p>
                        @auth
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'agent')
                                <a href="{{ route('admin.rumah-subsidi.create') }}"
                                    class="mt-4 inline-block rounded-lg bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700">
                                    Tambah Rumah Subsidi
                                </a>
                            @endif
                        @endauth
                    </div>
                @endforelse
            </div>

            {{-- More Rumah Subsidi --}}
            @if($properties->count() > 4)
                <h3 class="mb-6 text-xl font-bold text-gray-900">Rumah Subsidi Lainnya</h3>
                <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach($properties->skip(4) as $property)
                        @php
                            $images = ($property->images ?? collect())->sortBy('sort_order')->values();
                            $primaryImage = $images->firstWhere('is_primary', true) ?? $images->first();
                            $imageSrc = $normalizeImage($primaryImage?->path) ?: $fallbackImages->random();
                        @endphp

                        <a href="{{ route('property.show', $property->slug ?? $property->id) }}"
                            class="block overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">
                            <div class="relative aspect-video bg-gray-200">
                                <img src="{{ $imageSrc }}" alt="{{ $property->title }}"
                                    class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                            </div>
                            <div class="p-4">
                                <h4 class="mb-1 line-clamp-1 font-semibold text-gray-900">{{ $property->title }}</h4>
                                <p class="mb-2 line-clamp-1 text-xs text-gray-500">
                                    <i class="fa fa-map-marker mr-1"></i>
                                    {{ $property->city ?: 'Lokasi belum diisi' }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-blue-600">
                                        Rp {{ number_format((float) ($property->price ?? 0), 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $property->land_area ? number_format((float) $property->land_area) : '-' }} m²
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Info Section --}}
            <div class="mb-10 rounded-xl bg-blue-50 p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                        <i class="fa fa-info-circle text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Tentang Rumah Subsidi</h4>
                        <p class="mt-1 text-sm text-gray-600">
                            Rumah subsidi adalah program perumahan pemerintah dengan harga terjangkau.
                            Dengan persyaratan KTP dan KK, Anda bisa memiliki rumah idaman dengan cicilan ringan.
                            Konsultasikan dengan kami untuk informasi lebih lanjut tentang KPR subsidi.
                        </p>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            @auth
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'agent')
                    <div class="text-center">
                        <a href="{{ route('admin.rumah-subsidi.create') }}"
                            class="inline-block rounded-lg bg-green-600 px-6 py-3 font-medium text-white transition hover:bg-green-700">
                            <i class="fa fa-plus mr-2"></i>Tambah Rumah Subsidi
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>
@endsection
