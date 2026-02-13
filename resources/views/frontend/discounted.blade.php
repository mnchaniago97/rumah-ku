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
            <div class="bg-white rounded-xl p-4 shadow-sm mb-6">
                <div class="flex flex-wrap gap-4">
                    <select class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">Semua Tipe</option>
                        <option value="rumah">Rumah</option>
                        <option value="apartemen">Apartemen</option>
                        <option value="tanah">Tanah</option>
                        <option value="ruko">Ruko</option>
                    </select>
                    <select class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">Semua Lokasi</option>
                        <option value="jakarta">Jakarta</option>
                        <option value="bandung">Bandung</option>
                        <option value="surabaya">Surabaya</option>
                        <option value="tangerang">Tangerang</option>
                    </select>
                    <select class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">Urutkan: Diskon Terbesar</option>
                        <option value="price_asc">Harga: Termurah</option>
                        <option value="price_desc">Harga: Termahal</option>
                    </select>
                </div>
            </div>

            {{-- Properties Grid --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                @for($i = 1; $i <= 8; $i++)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition relative">
                        <div class="absolute top-3 left-3 z-10 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                            DISCON {{ 10 + $i * 5 }}%
                        </div>
                        <div class="aspect-[4/3] bg-gray-200 relative">
                            <img src="https://source.unsplash.com/600x400/?house,property&sig={{ $i + 20 }}" alt="Property" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-lg font-bold text-red-500 line-through text-gray-400">Rp {{ number_format(2000 + $i * 500, 0, ',', '.') }} JT</span>
                                <span class="text-lg font-bold text-blue-600">Rp {{ number_format(1500 + $i * 400, 0, ',', '.') }} JT</span>
                            </div>
                            <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ ['Rumah Minimalis di Jakarta Selatan', 'Apartemen Mewah di Bandung', 'Ruko Strategis di Surabaya', 'Tanah Kavling di Tangerang'][$i % 4] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ ['Jakarta Selatan', 'Bandung', 'Surabaya', 'Tangerang'][$i % 4] }}</p>
                            <div class="mt-3 flex items-center gap-3 text-xs text-gray-600">
                                <span><i class="fa fa-bed"></i> {{ 2 + ($i % 4) }}</span>
                                <span><i class="fa fa-bath"></i> {{ 1 + ($i % 3) }}</span>
                                <span><i class="fa fa-ruler-combined"></i> {{ 60 + $i * 20 }} m²</span>
                            </div>
                            <a href="#" class="mt-3 block w-full text-center py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center">
                <nav class="flex items-center gap-2">
                    <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center font-medium">1</a>
                    <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">2</a>
                    <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
@endsection
