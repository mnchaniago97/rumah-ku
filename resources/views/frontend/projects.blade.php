@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Proyek Properti Baru</h1>
                <p class="mt-2 text-gray-600">Temukan proyek perumahan dan komersial terbaru dari developer terpercaya</p>
            </div>

            {{-- Featured Projects --}}
            <div class="grid md:grid-cols-2 gap-6 mb-10">
                @for($i = 1; $i <= 4; $i++)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                        <div class="aspect-[16/9] bg-gray-200 relative">
                            <img src="https://source.unsplash.com/800x450/?building,construction&sig={{ $i }}" alt="Project" class="w-full h-full object-cover">
                            <span class="absolute top-4 left-4 bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full">
                                {{ ['Segera Dibuka', 'Dalam Konstruksi', 'Hampir Sold Out', 'Terbaru'][$i % 4] }}
                            </span>
                        </div>
                        <div class="p-5">
                            <h2 class="text-xl font-bold text-gray-900 mb-2">
                                {{ ['Grand Permata Residence', 'Green Valley Estate', 'Metropolitan Tower', 'Sunrise Garden Homes'][$i % 4] }}
                            </h2>
                            <p class="text-sm text-gray-500 mb-3">
                                <i class="fa fa-map-marker mr-1"></i>
                                {{ ['Jakarta Selatan', 'Tangerang', 'Bandung', 'Surabaya'][$i % 4] }}
                            </p>
                            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                                <span><i class="fa fa-home mr-1"></i> {{ 50 + $i * 10 }} Unit</span>
                                <span><i class="fa fa-calendar mr-1"></i> {{ 2024 + ($i % 3) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">Mulai dari</p>
                                    <p class="text-lg font-bold text-blue-600">
                                        {{ ['Rp 500 Juta', 'Rp 850 Juta', 'Rp 1,2 Miliar', 'Rp 750 Juta'][$i % 4] }}
                                    </p>
                                </div>
                                <a href="#" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Project List --}}
            <h3 class="text-xl font-bold text-gray-900 mb-6">Proyek Lainnya</h3>
            <div class="grid md:grid-cols-3 gap-6 mb-10">
                @for($i = 1; $i <= 6; $i++)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                        <div class="aspect-video bg-gray-200">
                            <img src="https://source.unsplash.com/600x400/?apartment,condo&sig={{ $i + 10 }}" alt="Project" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 mb-1 line-clamp-1">
                                {{ ['Diamond Tower', 'Crystal Residence', 'Platinum Garden', 'Emerald Heights', 'Ruby Place', 'Sapphire Ville'][$i % 6] }}
                            </h4>
                            <p class="text-xs text-gray-500 mb-2">
                                <i class="fa fa-map-marker mr-1"></i>
                                {{ ['Bekasi', 'Depok', 'Bogor', 'Semarang', 'Yogyakarta', 'Medan'][$i % 6] }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-blue-600">
                                    {{ ['Rp 400 Juta', 'Rp 650 Juta', 'Rp 550 Juta', 'Rp 700 Juta', 'Rp 450 Juta', 'Rp 600 Juta'][$i % 6] }}
                                </span>
                                <span class="text-xs text-gray-400">{{ 15 + $i * 5 }} unit tersedia</span>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Load More --}}
            <div class="text-center">
                <button class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                    Tampilkan Lebih Banyak
                </button>
            </div>
        </div>
    </div>
@endsection
