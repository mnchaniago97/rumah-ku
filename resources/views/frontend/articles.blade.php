@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Info Properti</h1>
                <p class="mt-2 text-gray-600">Tips, panduan, dan informasi menarik seputar properti</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @for($i = 1; $i <= 9; $i++)
                    <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                        <div class="aspect-video bg-gray-200">
                            <img src="https://source.unsplash.com/800x600/?house,property&sig={{ $i }}" alt="Article" class="w-full h-full object-cover">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded">Tips Membeli</span>
                                <span>{{ now()->subDays($i)->format('d M Y') }}</span>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                {{ ['Panduan Lengkap Membeli Rumah Pertama', 'Tips Negosiasi Harga Properti', '10 Kesalahan yang Harus Dihindari Saat Membeli Rumah', 'Cara Memilih Lokasi yang Tepat', 'Panduan KPR untuk Pemula', 'Tips Renovasi Rumah dengan Budget Terbatas', 'Cara Menjual Rumah dengan Cepat', 'Investasi Properti untuk Pemula', 'Tips Membangun Rumah dari Nol'][$i % 9] }}
                            </h2>
                            <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                                {{ ['Temukan panduan lengkap untuk membeli rumah pertama Anda, mulai dari menentukan budget hingga memilih lokasi yang tepat untuk kebutuhan Anda.', 
                                'Pelajari teknik negosiasi yang efektif untuk mendapatkan harga properti terbaik tanpa kehilangan kesempatan.', 
                                'Hindari kesalahan-kesalahan umum yang sering dilakukan pembeli rumah pemula dengan mengikuti panduan ini.',
                                'Memilih lokasi yang tepat adalah kunci keberhasilan investasi properti. Simak tipsnya di sini.',
                                'Panduan lengkap memahami proses KPR dari awal hingga persetujuan, khusus untuk pembeli pertama.',
                                'Renovasi rumah tidak harus mahal. Berikut tips renovasi hemat budget namun tetap estetik.',
                                'Jual rumah dengan cepat dan harga terbaik menggunakan strategi yang terbukti efektif.',
                                'Mulai investasi properti dengan modal minimal namun potensi keuntungan maksimal.',
                                'Panduan lengkap membangun rumah dari nol, mulai dari perencanaan hingga konstruksi.'][$i % 9] }}
                            </p>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </article>
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
                    <span class="px-2 text-gray-500">...</span>
                    <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">10</a>
                    <a href="#" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50">
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
@endsection
