@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Daftar Properti</h1>
                <div class="mt-4 md:mt-0 flex gap-2">
                    <select class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">Urutkan: Terbaru</option>
                        <option value="price_asc">Harga: Termurah</option>
                        <option value="price_desc">Harga: Termahal</option>
                        <option value="area_asc">Luas Tanah: Terkecil</option>
                        <option value="area_desc">Luas Tanah: Terbesar</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($properties as $property)
                    @php
                        $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                            ?? $property->images->sortBy('sort_order')->first()?->path
                            ?? '/assets/admin/images/product/product-01.jpg';
                    @endphp
                    <a href="{{ route('property.show', $property->slug ?: $property->getKey()) }}" class="block">
                        <div class="overflow-hidden rounded-xl bg-white shadow-sm hover:shadow-md transition">
                            <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                                <img src="{{ $cardImage }}" alt="{{ $property->title }}"
                                    class="h-full w-full object-cover hover:scale-105 transition duration-300" />
                            </div>

                            <div class="p-4">
                                <div class="flex items-end gap-2">
                                    <p class="text-lg font-bold text-blue-600">
                                        {{ $property->price ? 'Rp ' . number_format($property->price, 0, ',', '.') : 'Hubungi Kami' }}
                                    </p>
                                </div>
                                <p class="mt-2 line-clamp-2 text-sm font-medium text-gray-900">
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
                                        {{ ($property->land_area ?? 0) + ($property->building_area ?? 0) }} m²
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full rounded-xl border border-dashed border-gray-200 bg-white p-12 text-center">
                        <i class="fa fa-home text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada properti yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if(method_exists($properties, 'links') && $properties instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @elseif($properties instanceof \Illuminate\Database\Eloquent\Collection && $properties->count() >= 12)
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center gap-2">
                        <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">
                            <i class="fa fa-chevron-left"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center font-medium">1</a>
                        <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">2</a>
                        <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">3</a>
                        <span class="px-2 text-gray-500">...</span>
                        <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">10</a>
                        <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </nav>
                </div>
            @endif
        </div>
    </div>
@endsection
