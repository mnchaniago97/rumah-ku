@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50">
        {{-- Hero Section --}}
        <section class="relative bg-gradient-to-br from-green-700 to-green-500 py-16 text-white">
            <div class="absolute inset-0 overflow-hidden">
                <img src="/assets/frontend/img/welcome-bg.png" alt="Background" class="w-full h-full object-cover opacity-20">
            </div>
            <div class="max-w-[1200px] mx-auto px-4 relative text-center">
                <h1 class="text-3xl md:text-4xl font-bold">Iklankan Properti Anda</h1>
                <p class="mx-auto mt-3 max-w-xl text-green-100">Jual atau sewakan properti Anda dengan mudah dan cepat. Millions calon pembeli menunggu!</p>
            </div>
        </section>

        <div class="max-w-[1200px] mx-auto px-4 py-12">
            {{-- Steps --}}
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-gray-900">Cara Pasang Iklan</h2>
                <p class="mt-2 text-gray-600">3 langkah mudah untuk memasang iklan properti Anda</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Daftar/Masuk</h3>
                    <p class="text-sm text-gray-600">Buat akun atau masuk ke akun Anda untuk memulai.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-green-600">2</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Isi Data Properti</h3>
                    <p class="text-sm text-gray-600">Lengkapi informasi properti Anda dengan detail dan foto berkualitas.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">3</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Publikasikan</h3>
                    <p class="text-sm text-gray-600">Properti Anda akan langsung terlihat oleh jutaan pengunjung.</p>
                </div>
            </div>

            {{-- Benefits --}}
            <div class="bg-white rounded-xl p-8 shadow-sm mb-10">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Keunggulan pasang iklan di Rumah Ku</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-eye text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Jutaan Pengunjung</h4>
                            <p class="text-sm text-gray-600">Properti Anda dilihat oleh ribuan calon pembeli setiap hari.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-bolt text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Cepat & Mudah</h4>
                            <p class="text-sm text-gray-600">Proses posting hanya membutuhkan waktu beberapa menit.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-camera text-purple-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Upload Foto Unlimited</h4>
                            <p class="text-sm text-gray-600">Tambahkan foto sebanyak mungkin untuk menarik minat pembeli.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-chart-line text-yellow-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Gratis</h4>
                            <p class="text-sm text-gray-600">Pasang iklan properti tanpa biaya sepesenpun.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-8 text-white text-center">
                <h3 class="text-2xl font-bold mb-3">Siap memasang iklan?</h3>
                <p class="text-blue-100 mb-6">Bergabunglah dengan ribuan agen dan pemilik properti yang sukses di Rumah Ku</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('contact') }}" class="px-8 py-3 border border-white text-white font-semibold rounded-lg hover:bg-white/10 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
