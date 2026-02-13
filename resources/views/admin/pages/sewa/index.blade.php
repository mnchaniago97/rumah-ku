@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Properti Sewa</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola listing properti sewa.</p>
            </div>
            <a href="{{ route('admin.sewa.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-green-700">
                + Tambah Properti Sewa
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid w-full grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($properties as $property)
                @php
                    $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                        ?? $property->images->sortBy('sort_order')->first()?->path
                        ?? 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=512';

                    if (!empty($cardImage) && !str_starts_with($cardImage, 'http://') && !str_starts_with($cardImage, 'https://') && !str_starts_with($cardImage, '/')) {
                        $cardImage = '/storage/' . ltrim($cardImage, '/');
                    }
                    
                    $bedrooms = filled($property->bedrooms) ? $property->bedrooms : '-';
                    $bathrooms = filled($property->bathrooms) ? $property->bathrooms : '-';
                    $area = $property->land_area ?? $property->building_area;
                    $pricePeriod = $property->price_period ? '/ ' . $property->price_period : '';
                @endphp
                <div class="relative w-full">
                    <div class="relative inline-block w-full transform transition-transform duration-300 ease-in-out hover:-translate-y-2">
                        <div class="rounded-lg bg-white p-4 shadow">
                            <a href="{{ route('admin.sewa.show', $property->id ?? $property->getKey()) }}"
                                class="block rounded-lg focus:outline-hidden focus:ring-2 focus:ring-green-500/40">
                                <div class="relative flex h-52 justify-center overflow-hidden rounded-lg">
                                    <div class="w-full transform transition-transform duration-500 ease-in-out hover:scale-110">
                                        <img src="{{ $cardImage }}" alt="{{ $property->title }}" class="h-full w-full object-cover" loading="lazy" />
                                    </div>

                                    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/60 to-transparent"></div>

                                    <div class="absolute bottom-0 left-5 mb-3 flex">
                                        <p class="flex items-center font-medium text-white shadow-sm">
                                            <i class="fa fa-camera mr-2 text-xl text-white"></i>
                                            {{ $property->images->count() }}
                                        </p>
                                    </div>

                                    <span class="absolute top-0 right-2 z-10 mt-3 ml-3 inline-flex select-none rounded-sm bg-blue-600 px-2 py-1 text-xs font-semibold text-white">
                                        Sewa
                                    </span>
                                </div>

                                <div class="mt-4">
                                    <h2 class="line-clamp-1 text-2xl font-medium text-gray-800 md:text-lg" title="{{ $property->title }}">
                                        {{ $property->title }}
                                    </h2>
                                    <p class="text-primary mt-2 inline-block whitespace-nowrap rounded-xl font-semibold leading-tight">
                                        <span class="text-sm uppercase">Rp</span>
                                        <span class="text-2xl">{{ $property->price ? number_format($property->price, 0, ',', '.') : '0' }}</span>
                                        <span class="text-sm">{{ $pricePeriod }}</span>
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <p class="line-clamp-1 mt-2 text-lg text-gray-800">
                                        <i class="fa fa-map-marker mr-2 text-gray-400"></i>
                                        {{ $property->city ?? 'Belum diisi' }}
                                    </p>
                                </div>
                                <div class="justify-center">
                                    <div class="mt-4 flex flex-wrap gap-3 overflow-hidden rounded-lg px-1 py-1">
                                        <p class="flex items-center font-medium text-gray-800">
                                            <i class="fa fa-bed mr-2 text-blue-900"></i>
                                            {{ $bedrooms }}
                                        </p>
                                        <p class="flex items-center font-medium text-gray-800">
                                            <i class="fa fa-bath mr-2 text-blue-900"></i>
                                            {{ $bathrooms }}
                                        </p>
                                        <p class="flex items-center font-medium text-gray-800">
                                            <i class="fa fa-expand mr-2 text-blue-900"></i>
                                            {{ $area ?? '-' }} m²
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="mt-6 flex gap-2">
                                <a href="{{ route('admin.sewa.edit', $property->id ?? $property->getKey()) }}"
                                    class="flex-1 rounded-lg bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-blue-700">
                                    <i class="fa fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.sewa.destroy', $property->id ?? $property->getKey()) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus properti sewa ini?')">
                                        <i class="fa fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-xl border border-dashed border-gray-200 bg-white p-6 text-center text-sm text-gray-500 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400">
                    <i class="fa fa-home text-4xl text-gray-300 mb-3"></i>
                    <p>Belum ada properti sewa.</p>
                    <a href="{{ route('admin.sewa.create') }}" class="inline-block mt-3 text-blue-600 hover:underline">
                        Tambah Properti Sewa Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
