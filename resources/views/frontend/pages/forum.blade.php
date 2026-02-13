@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Teras123 - Forum Properti</h1>
                <p class="mt-2 text-gray-600">Tanya jawab, berbagi pengalaman, dan diskusi dengan komunitas properti Indonesia</p>
            </div>

            {{-- Categories --}}
            <div class="grid md:grid-cols-4 gap-4 mb-10">
                <a href="#" class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition text-center">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-home text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Bel Rumah</h3>
                    <p class="text-sm text-gray-500">Tips dan trik beli rumah</p>
                </a>
                <a href="#" class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition text-center">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-file-signature text-2xl text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">KPR</h3>
                    <p class="text-sm text-gray-500">Discuss KPR and financing</p>
                </a>
                <a href="#" class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition text-center">
                    <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-building text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Investasi</h3>
                    <p class="text-sm text-gray-500">Properti sebagai investasi</p>
                </a>
                <a href="#" class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition text-center">
                    <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-tools text-2xl text-yellow-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Renovasi</h3>
                    <p class="text-sm text-gray-500">Tips renovasi dan desain</p>
                </a>
            </div>

            {{-- Popular Topics --}}
            <div class="bg-white rounded-xl shadow-sm mb-10">
                <div class="p-5 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-gray-900">Topik Populer</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @for($i = 1; $i <= 5; $i++)
                        <div class="p-5 hover:bg-gray-50 transition cursor-pointer">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0">
                                    <img src="https://i.pravatar.cc/100?img={{ 30 + $i }}" alt="User" class="w-full h-full rounded-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 hover:text-blue-600">
                                        {{ ['Pengalaman beli rumah pertama di usia 25 tahun', 'Tips nego harga yang sukses dapat diskon 50 juta', 'Bandingkan suku bunga KPR bank mana paling murah?', 'Rumah tapak vs apartemen, mana lebih bagus untuk investasi?', 'Renovasi rumah tua jadi minimalis modern dengan budget 100 juta'][$i % 5] }}
                                    </h4>
                                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                        <span><i class="far fa-user mr-1"></i> {{ ['Andi123', 'WiraProperti', 'RumahImpian', 'Investor Muda', 'ArchitectFan'][$i % 5] }}</span>
                                        <span><i class="far fa-clock mr-1"></i> {{ ['2 jam', '5 jam', '1 hari', '2 hari', '3 hari'][$i % 5] }} lalu</span>
                                        <span><i class="far fa-comment mr-1"></i> {{ 10 + $i * 5 }} jawaban</span>
                                        <span><i class="far fa-eye mr-1"></i> {{ 100 + $i * 50 }} views</span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">{{ ['Bel Rumah', 'Tips', 'KPR', 'Investasi', 'Renovasi'][$i % 5] }}</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="p-5 border-t border-gray-100 text-center">
                    <a href="#" class="text-blue-600 font-medium hover:text-blue-700">Lihat Semua Topik →</a>
                </div>
            </div>

            {{-- Latest Questions --}}
            <h3 class="text-xl font-bold text-gray-900 mb-6">Pertanyaan Terbaru</h3>
            <div class="space-y-4 mb-10">
                @for($i = 1; $i <= 8; $i++)
                    <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0 text-sm font-medium text-gray-600">
                                {{ $i }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 hover:text-blue-600">
                                    {{ ['Apakah bisa KPR tanpa DP?', 'Berapa biaya notary untuk AJB rumah second?', 'Properti di BSD masih worth it untuk investasi', 'Tips pilih lokasi buat rumah pertama', 'Pengalaman take over KPR dari mertua', 'Rekomendasi agen terpercaya di Surabaya', 'Berapa persen kenaikan properti per tahun', 'Rumah subsidi vs komersial'][$i % 8] }}
                                </h4>
                                <div class="flex items-center gap-4 mt-1 text-sm text-gray-500">
                                    <span><i class="far fa-comment mr-1"></i> {{ $i * 3 }} jawaban</span>
                                    <span><i class="far fa-clock mr-1"></i> {{ $i }} jam lalu</span>
                                </div>
                            </div>
                            <a href="#" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                                Jawaban
                            </a>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- CTA --}}
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-8 text-white text-center">
                <h3 class="text-2xl font-bold mb-3">Punya Pertanyaan?</h3>
                <p class="text-purple-200 mb-6">Bergabung dengan komunitas dan ajukan pertanyaan Anda</p>
                <a href="#" class="inline-block px-8 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-purple-50 transition">
                    Daftar Gratis
                </a>
            </div>
        </div>
    </div>
@endsection
