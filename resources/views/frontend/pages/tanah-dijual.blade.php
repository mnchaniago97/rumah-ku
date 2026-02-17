@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 bg-green-100 text-green-600 px-4 py-2 rounded-full mb-4">
                    <i class="fas fa-map"></i>
                    <span class="font-medium">Tanah Dijual</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Tanah Dijual</h1>
                <p class="mt-2 text-gray-600">Temukan tanah impian Anda untuk investasi atau pembangunan</p>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-xl p-4 shadow-sm mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari lokasi, nama..."
                        class="flex-1 min-w-[200px] rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    
                    <select name="location" class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">Semua Lokasi</option>
                        @foreach($locations as $location)
                            <option value="{{ $location }}" @selected(request('location') === $location)>{{ $location }}</option>
                        @endforeach
                    </select>

                    <select name="sort" class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="latest" @selected(request('sort') === 'latest')>Terbaru</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga: Termurah</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga: Termahal</option>
                    </select>

                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                        <i class="fa fa-search mr-2"></i>Filter
                    </button>
                </form>
            </div>

            @if($properties->count() > 0)
                {{-- Properties Grid --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                    @foreach($properties as $property)
                        <a href="{{ route('property.show', $property->slug) }}" class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition group">
                            <div class="aspect-[4/3] bg-gray-200 relative">
                                @if($property->images->first())
                                    <img src="{{ $property->images->first()->path }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200">
                                        <i class="fa fa-map text-4xl text-green-400"></i>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
                                    Tanah
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-lg font-bold text-blue-600">Rp {{ number_format($property->price, 0, ',', '.') }}</p>
                                <p class="text-sm font-medium text-gray-900 line-clamp-2 mt-1">{{ $property->title }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fa fa-map-marker-alt mr-1"></i>
                                    {{ $property->city ?? '-' }}{{ $property->province ? ', ' . $property->province : '' }}
                                </p>
                                <div class="mt-3 flex items-center gap-3 text-xs text-gray-600">
                                    @if($property->land_area)
                                        <span><i class="fa fa-ruler-combined"></i> {{ number_format($property->land_area) }} m²</span>
                                    @endif
                                    @if($property->certificate)
                                        <span><i class="fa fa-file-alt"></i> {{ $property->certificate }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($properties->hasPages())
                    <div class="flex justify-center">
                        {{ $properties->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white rounded-xl p-12 text-center shadow-sm">
                    <i class="fa fa-map text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-700">Belum ada tanah dijual</h3>
                    <p class="text-gray-500 mt-2">Saat ini belum ada listing tanah yang tersedia.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
