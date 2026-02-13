@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Lainnya</h1>
                <p class="mt-2 text-gray-600">Temukan lebih banyak layanan dan informasi properti</p>
            </div>

            {{-- All Shortcut Links --}}
            <div class="grid md:grid-cols-3 gap-6 mb-10">
                <button type="button" data-open-property-inquiry class="w-full text-left bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center group-hover:bg-blue-600 transition">
                            <i class="fas fa-search text-2xl text-blue-600 group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Carikan Properti</h3>
                            <p class="text-sm text-gray-500">Bantuan mencari properti sesuai kebutuhan</p>
                        </div>
                    </div>
                </button>

                <a href="{{ route('advertise') }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center group-hover:bg-green-600 transition">
                            <i class="fas fa-bullhorn text-2xl text-green-600 group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Iklankan Properti</h3>
                            <p class="text-sm text-gray-500">Pasang iklan properti Anda</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('agents') }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center group-hover:bg-purple-600 transition">
                            <i class="fas fa-users text-2xl text-purple-600 group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Cari Agen</h3>
                            <p class="text-sm text-gray-500">Temukan agen terpercaya</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('discounted') }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-red-100 flex items-center justify-center group-hover:bg-red-600 transition">
                            <i class="fas fa-arrow-down text-2xl text-red-600 group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Properti Turun Harga</h3>
                            <p class="text-sm text-gray-500">Hot deals dan diskon properti</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('calculator') }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-yellow-100 flex items-center justify-center group-hover:bg-yellow-600 transition">
                            <i class="fas fa-calculator text-2xl text-yellow-600 group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Kalkulator KPR</h3>
                            <p class="text-sm text-gray-500">Hitung cicilan rumah tangga</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('takeover') }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-600 transition">
                            <i class="fas fa-exchange-alt text-2xl text-indigo-600 group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Pindah KPR</h3>
                            <p class="text-sm text-gray-500">Take over KPR rumah</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('forum') }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-pink-100 flex items-center justify-center group-hover:bg-pink-600 transition">
                            <i class="fas fa-comments text-2xl text-pink-600 group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Tanya Forum</h3>
                            <p class="text-sm text-gray-500">Teras123 - Forum properti</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('articles') }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-teal-100 flex items-center justify-center group-hover:bg-teal-600 transition">
                            <i class="fas fa-newspaper text-2xl text-teal-600 group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Artikel</h3>
                            <p class="text-sm text-gray-500">Tips dan info properti</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('projects') }}" class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-cyan-100 flex items-center justify-center group-hover:bg-cyan-600 transition">
                            <i class="fas fa-building text-2xl text-cyan-600 group-hover:text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Proyek Properti</h3>
                            <p class="text-sm text-gray-500">Proyek perumahan baru</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Useful Links --}}
            <div class="bg-white rounded-xl p-8 shadow-sm mb-10">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Tautan Berguna</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-book text-blue-600"></i>
                        <span class="text-gray-700">Panduan Membeli</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-file-contract text-green-600"></i>
                        <span class="text-gray-700">Dokumen Properti</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-shield-alt text-purple-600"></i>
                        <span class="text-gray-700">Keamanan Transaksi</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-question-circle text-yellow-600"></i>
                        <span class="text-gray-700">FAQ</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-globe text-indigo-600"></i>
                        <span class="text-gray-700">Peta Lokasi</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-calculator text-red-600"></i>
                        <span class="text-gray-700">Simulasi KPR</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-chart-line text-cyan-600"></i>
                        <span class="text-gray-700">Harga Properti</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-hands-helping text-pink-600"></i>
                        <span class="text-gray-700">Kerjasama</span>
                    </a>
                </div>
            </div>

            {{-- Apps --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-8 text-white text-center">
                <h2 class="text-2xl font-bold mb-3">Download Aplikasi Rumah Ku</h2>
                <p class="text-blue-100 mb-6">Dapatkan kemudahan mencari properti di mana saja, kapan saja</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="inline-flex items-center gap-3 px-6 py-3 bg-white text-gray-900 rounded-lg hover:bg-gray-100 transition">
                        <i class="fab fa-google-play text-2xl text-blue-600"></i>
                        <div class="text-left">
                            <p class="text-xs">Get it on</p>
                            <p class="font-semibold">Google Play</p>
                        </div>
                    </a>
                    <a href="#" class="inline-flex items-center gap-3 px-6 py-3 bg-white text-gray-900 rounded-lg hover:bg-gray-100 transition">
                        <i class="fab fa-apple text-2xl"></i>
                        <div class="text-left">
                            <p class="text-xs">Download on the</p>
                            <p class="font-semibold">App Store</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
