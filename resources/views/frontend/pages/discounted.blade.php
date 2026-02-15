@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 bg-red-100 text-red-600 px-4 py-2 rounded-full mb-4">
                    <i class="fas fa-tag"></i>
                    <span class="font-medium">Hot Deals</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Properti Turun Harga</h1>
                <p class="mt-2 text-gray-600">Segera pesan sebelum kehabisan! Penawaran terbatas dengan harga terbaik</p>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route('discounted') }}" class="bg-white rounded-xl p-4 shadow-sm mb-6">
                <div class="flex flex-wrap gap-4">
                    <select name="type" class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">Semua Tipe</option>
                        @foreach($typeOptions as $type)
                            <option value="{{ $type }}" {{ $filters['type'] === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="city" class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">Semua Lokasi</option>
                        @foreach($cityOptions as $city)
                            <option value="{{ $city }}" {{ $filters['city'] === $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                    <select name="sort" class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="discount_desc" {{ $filters['sort'] === 'discount_desc' ? 'selected' : '' }}>Urutkan: Diskon Terbesar</option>
                        <option value="price_asc" {{ $filters['sort'] === 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                        <option value="price_desc" {{ $filters['sort'] === 'price_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                        Filter
                    </button>
                </div>
            </form>

            {{-- Properties Grid --}}
            @if($properties->count() > 0)
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                    @foreach($properties as $property)
                        @php
                            $discountPercentage = $property->getDiscountPercentage();
                            $primaryImage = $property->images->firstWhere('is_primary') ?? $property->images->first();
                        @endphp
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition relative">
                            @if($discountPercentage)
                                <div class="absolute top-3 left-3 z-10 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    DISCON {{ $discountPercentage }}%
                                </div>
                            @endif
                            <div class="aspect-[4/3] bg-gray-200 relative">
                                @if($primaryImage)
                                    <img src="{{ $primaryImage->path }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="fas fa-home text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    @if($property->original_price)
                                        <span class="text-lg font-bold text-red-500 line-through text-gray-400">
                                            Rp {{ number_format($property->original_price / 1000000, 0, ',', '.') }} JT
                                        </span>
                                    @endif
                                    <span class="text-lg font-bold text-blue-600">
                                        Rp {{ number_format($property->price / 1000000, 0, ',', '.') }} JT
                                    </span>
                                </div>
                                <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $property->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $property->city }}</p>
                                <div class="mt-3 flex items-center gap-3 text-xs text-gray-600">
                                    @if($property->bedrooms)
                                        <span><i class="fa fa-bed"></i> {{ $property->bedrooms }}</span>
                                    @endif
                                    @if($property->bathrooms)
                                        <span><i class="fa fa-bath"></i> {{ $property->bathrooms }}</span>
                                    @endif
                                    @if($property->land_area)
                                        <span><i class="fa fa-ruler-combined"></i> {{ $property->land_area }} m²</span>
                                    @endif
                                </div>
                                <a href="{{ route('property.show', $property->slug) }}" class="mt-3 block w-full text-center py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center">
                    {{ $properties->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-home text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum Ada Properti Turun Harga</h3>
                    <p class="mt-1 text-gray-500">Saat ini tidak ada properti dengan harga turun. Silakan cek kembali nanti.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
