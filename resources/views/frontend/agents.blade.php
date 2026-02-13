@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Cari Agen Properti</h1>
                <p class="mt-2 text-gray-600">Temukan agen properti terpercaya di sekitar Anda</p>
            </div>

            {{-- Search Agent --}}
            <div class="bg-white rounded-xl p-6 shadow-sm mb-10">
                <form class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" placeholder="Cari berdasarkan nama atau lokasi..." class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="w-full md:w-48">
                        <select class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kota</option>
                            <option value="jakarta">Jakarta</option>
                            <option value="surabaya">Surabaya</option>
                            <option value="bandung">Bandung</option>
                            <option value="tangerang">Tangerang</option>
                            <option value="bekasi">Bekasi</option>
                            <option value="depok">Depok</option>
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                        <i class="fa fa-search mr-2"></i>Cari
                    </button>
                </form>
            </div>

            {{-- Top Agents --}}
            <h3 class="text-xl font-bold text-gray-900 mb-6">Agen Pilihan</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                @for($i = 1; $i <= 8; $i++)
                    <div class="bg-white rounded-xl p-5 shadow-sm text-center hover:shadow-md transition">
                        <div class="w-20 h-20 rounded-full bg-gray-200 mx-auto mb-4 overflow-hidden">
                            <img src="https://i.pravatar.cc/150?img={{ 10 + $i }}" alt="Agent" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-semibold text-gray-900">
                            {{ ['Ahmad Wijaya', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Lestari', 'Rudi Hartono', 'Maya Sari', 'Joko Prasetyo', 'Lisa Amelia'][$i % 8] }}
                        </h4>
                        <p class="text-sm text-gray-500 mb-3">
                            {{ ['PT Realty Indo', 'Global Property', 'Prime Estate', 'Smart Homes'][$i % 4] }}
                        </p>
                        <div class="flex items-center justify-center gap-1 mb-4">
                            @for($star = 1; $star <= 5; $star++)
                                <i class="fa fa-star text-yellow-400 text-xs"></i>
                            @endfor
                            <span class="text-xs text-gray-500 ml-1">({{ 50 + $i * 10 }})</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="#" class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                <i class="fa fa-phone mr-1"></i>Telepon
                            </a>
                            <a href="#" class="flex-1 px-3 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition">
                                <i class="fa fa-whatsapp mr-1"></i>WhatsApp
                            </a>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- All Agents List --}}
            <h3 class="text-xl font-bold text-gray-900 mb-6">Semua Agen</h3>
            <div class="space-y-4">
                @for($i = 1; $i <= 5; $i++)
                    <div class="bg-white rounded-xl p-5 shadow-sm flex flex-col md:flex-row items-center gap-4 hover:shadow-md transition">
                        <div class="flex items-center gap-4 flex-1">
                            <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                                <img src="https://i.pravatar.cc/150?img={{ 20 + $i }}" alt="Agent" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">
                                    {{ ['Hendra Gunawan', 'Ratna Dewi', 'Tomi Wijaya', 'Nina Kusuma', 'Andi Pratama'][$i % 5] }}
                                </h4>
                                <p class="text-sm text-gray-500">Agent Korporat - {{ ['Jakarta Selatan', 'Jakarta Pusat', 'Tangerang', 'Bandung', 'Surabaya'][$i % 5] }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ 100 + $i * 20 }} properti terdaftar</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-center">
                                <div class="flex items-center gap-1">
                                    @for($star = 1; $star <= 5; $star++)
                                        <i class="fa fa-star text-yellow-400 text-xs"></i>
                                    @endfor
                                </div>
                                <p class="text-xs text-gray-500">{{ 80 + $i * 5 }} review</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="#" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">
                                    Lihat Profil
                                </a>
                                <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                                    Hubungi
                                </a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Pagination --}}
            <div class="mt-10 flex justify-center">
                <nav class="flex items-center gap-2">
                    <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-lg bg-blue-600 text-white flex items-center justify-center font-medium">1</a>
                    <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">2</a>
                    <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">3</a>
                    <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
@endsection
