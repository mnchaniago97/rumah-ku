@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50">
        {{-- Hero Section --}}
        <section class="relative bg-gradient-to-br from-blue-900 to-blue-700 py-16 text-white">
            <div class="absolute inset-0 overflow-hidden">
                <img src="/assets/frontend/img/welcome-bg.png" alt="Background" class="w-full h-full object-cover opacity-20">
            </div>
            <div class="max-w-[1200px] mx-auto px-4 relative text-center">
                <h1 class="text-3xl md:text-4xl font-bold">Tentang Rumah Ku</h1>
                <p class="mx-auto mt-3 max-w-xl text-blue-100">Platform properti terpercaya Indonesia</p>
            </div>
        </section>

        <div class="max-w-[1200px] mx-auto px-4 py-12">
            {{-- About Content --}}
            <div class="bg-white rounded-xl p-8 shadow-sm mb-10">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Tentang Kami</h2>
                <div class="prose prose-lg text-gray-600">
                    <p class="mb-4">
                        <strong>Rumah Ku</strong> adalah platform properti terpercaya yang berkomitmen untuk membantu Anda menemukan rumah impian dengan mudah, aman, dan transparan. Kami menyediakan berbagai pilihan properti dari seluruh Indonesia, mulai dari rumah tinggal, apartemen, villa, ruko, hingga tanah.
                    </p>
                    <p class="mb-4">
                        Didukung oleh tim profesional yang berpengalaman di bidang properti, kami berkomitmen untuk memberikan pelayanan terbaik bagi setiap klien kami. Baik Anda pembeli, penjual, maupun penyewa properti, Rumah Ku siap membantu kebutuhan properti Anda.
                    </p>
                    <p>
                        Kami percaya bahwa memiliki rumah adalah impian setiap orang. Oleh karena itu, kami terus berinovasi untuk memberikan pengalaman pencarian properti yang lebih mudah, cepat, dan terpercaya.
                    </p>
                </div>
            </div>

            {{-- Vision & Mission --}}
            <div class="grid md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                        <i class="fa fa-eye text-xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Visi</h3>
                    <p class="text-gray-600">Menjadi platform properti nomor satu di Indonesia yang dipercaya oleh seluruh masyarakat dalam menemukan rumah impian mereka.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mb-4">
                        <i class="fa fa-bullseye text-xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Misi</h3>
                    <ul class="text-gray-600 space-y-2">
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check text-green-500 mt-1"></i>
                            <span>Menyediakan informasi properti yang akurat dan terpercaya</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check text-green-500 mt-1"></i>
                            <span>Memberikan pelayanan profesional dan responsif</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check text-green-500 mt-1"></i>
                            <span>Membangun ekosistem properti yang transparan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa fa-check text-green-500 mt-1"></i>
                            <span>Terus berinovasi untuk kemudahan pengguna</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Stats --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-8 text-white mb-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="text-3xl md:text-4xl font-bold">10.000+</div>
                        <div class="mt-1 text-blue-200">Properti Terdaftar</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold">5.000+</div>
                        <div class="mt-1 text-blue-200">Agen Terpercaya</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold">50.000+</div>
                        <div class="mt-1 text-blue-200">Pengguna Aktif</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold">2018</div>
                        <div class="mt-1 text-blue-200">Tahun Berdiri</div>
                    </div>
                </div>
            </div>

            {{-- Values --}}
            <div class="bg-white rounded-xl p-8 shadow-sm">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Nilai-Nilai Kami</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fa fa-heart text-2xl text-red-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Integritas</h3>
                        <p class="text-sm text-gray-600">Kami menjunjung tinggi kejujuran dan transparansi dalam setiap transaksi.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fa fa-star text-2xl text-yellow-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Kualitas</h3>
                        <p class="text-sm text-gray-600">Kami hanya menampilkan properti berkualitas tinggi untuk Anda.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fa fa-users text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Pelayanan</h3>
                        <p class="text-sm text-gray-600">Kepuasan Anda adalah prioritas utama kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
