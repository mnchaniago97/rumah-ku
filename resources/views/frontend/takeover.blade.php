@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50">
        {{-- Hero Section --}}
        <section class="relative bg-gradient-to-br from-indigo-700 to-indigo-500 py-16 text-white">
            <div class="absolute inset-0 overflow-hidden">
                <img src="/assets/frontend/img/welcome-bg.png" alt="Background" class="w-full h-full object-cover opacity-20">
            </div>
            <div class="max-w-[1200px] mx-auto px-4 relative text-center">
                <h1 class="text-3xl md:text-4xl font-bold">Pindah KPR (Take Over)</h1>
                <p class="mx-auto mt-3 max-w-xl text-indigo-100">Ingin melepaskan beban KPR? Atau ingin mengambil alih KPR rumah seseorang? Kami siap membantu.</p>
            </div>
        </section>

        <div class="max-w-[1200px] mx-auto px-4 py-12">
            {{-- What is KPR Takeover --}}
            <div class="bg-white rounded-xl p-8 shadow-sm mb-10">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Apa itu Pindah KPR?</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-600 mb-3">Untuk Penjual</h3>
                        <p class="text-gray-600 mb-4">
                            Jika Anda ingin melepaskan kewajiban KPR atas properti yang Anda jual, proses take over KPR dapat membantu pembeli mengambil alih sisa kewajiban KPR Anda. Ini memudahkan penjualan properti yang masih dalam beban KPR.
                        </p>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Proses lebih cepat dibanding KPR baru</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Tidak perlu menunggu persetujuan bank baru</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Menghindari denda pelunasan dini</span>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-600 mb-3">Untuk Pembeli</h3>
                        <p class="text-gray-600 mb-4">
                            Ambil alih KPR rumah yang sudah jadi,不必 repot membangun dari nol. Cocok untuk Anda yang ingin langsung tinggal di rumah yang sudah terbangun.
                        </p>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Bisa langsung huni atau disewakan</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Cicilan sudah jelas dan pasti</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Lebih mudah dibanding KPR konvensional</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Available Properties for Takeover --}}
            <h3 class="text-xl font-bold text-gray-900 mb-6">Properti Tersedia untuk Take Over</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @for($i = 1; $i <= 6; $i++)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                        <div class="aspect-video bg-gray-200 relative">
                            <img src="https://source.unsplash.com/600x400/?house,home&sig={{ $i + 30 }}" alt="Property" class="w-full h-full object-cover">
                            <div class="absolute top-3 left-3 bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded">
                                Take Over
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="text-sm text-gray-500 mb-1">Sisa Tenor: {{ 10 + $i * 2 }} Tahun</p>
                            <p class="font-semibold text-gray-900 line-clamp-1">{{ ['Rumah di Cluster Greenwood', 'Apartemen di Skyline Tower', 'Rumah di Vila Melati', 'Townhouse di Kemang'][$i % 4] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ ['Jakarta Barat', 'Jakarta Selatan', 'Tangerang', 'Bandung'][$i % 4] }}</p>
                            <div class="mt-3 flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">Cicilan per bulan</p>
                                    <p class="text-lg font-bold text-indigo-600">Rp {{ number_format(3 + $i, 0, ',', '.') }}.000.000</p>
                                </div>
                                <a href="#" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- CTA --}}
            <div class="bg-indigo-600 rounded-xl p-8 text-white text-center">
                <h3 class="text-2xl font-bold mb-3">Ingin Jual atau Beli via Take Over?</h3>
                <p class="text-indigo-200 mb-6">Hubungi tim kami untuk konsultasi gratis</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/6281234567890" class="px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition">
                        <i class="fab fa-whatsapp mr-2"></i>Chat WhatsApp
                    </a>
                    <a href="{{ route('contact') }}" class="px-8 py-3 border border-white text-white font-semibold rounded-lg hover:bg-white/10 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
