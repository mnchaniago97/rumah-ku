@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Hasil Pencarian</h1>
                <p class="mt-1 text-gray-600">Menampilkan hasil untuk: <span class="font-medium">{{ $query ?? 'Semua' }}</span></p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($properties ?? [] as $property)
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
                                <p class="text-lg font-bold text-blue-600">
                                    {{ $property->price ? 'Rp ' . number_format($property->price, 0, ',', '.') : 'Hubungi Kami' }}
                                </p>
                                <p class="mt-2 line-clamp-2 text-sm font-medium text-gray-900">{{ $property->title }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $property->city ?? '-' }}</p>
                                <div class="mt-3 flex items-center gap-3 text-xs text-gray-600">
                                    <span><i class="fa fa-bed"></i> {{ $property->bedrooms ?? '-' }}</span>
                                    <span><i class="fa fa-bath"></i> {{ $property->bathrooms ?? '-' }}</span>
                                    <span><i class="fa fa-ruler-combined"></i> {{ ($property->land_area ?? 0) + ($property->building_area ?? 0) }} m²</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full rounded-xl border border-dashed border-gray-200 bg-white p-12 text-center">
                        <i class="fa fa-search text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Tidak ditemukan properti dengan kriteria tersebut.</p>
                        <a href="{{ route('properties') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700">Lihat semua properti</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
