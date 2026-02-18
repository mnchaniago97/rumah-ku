@extends('frontend.layouts.app')

@section('content')
{{-- Hero Banner --}}
@if(isset($heroBanners) && $heroBanners->count() > 0)

    {{-- ================= DESKTOP HERO ================= --}}
    <div class="relative hidden md:block">
        <div id="hero-carousel" class="overflow-hidden rounded-b-[40px] mx-[50px]">
            <div class="flex transition-transform duration-500 ease-in-out" id="hero-slides">
                @foreach($heroBanners as $index => $banner)
                    <div class="w-full flex-shrink-0">
                        <a href="{{ $banner->link ?? '#' }}" class="block">
                            <img src="{{ Storage::url($banner->image) }}"
                                 alt="{{ $banner->title ?? 'Hero Banner' }}"
                                 class="w-full object-cover">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        @if($heroBanners->count() > 1)
            <button id="hero-prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/80 shadow-lg flex items-center justify-center text-gray-700 hover:bg-white transition">
                <i class="fa fa-chevron-left"></i>
            </button>

            <button id="hero-next" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/80 shadow-lg flex items-center justify-center text-gray-700 hover:bg-white transition">
                <i class="fa fa-chevron-right"></i>
            </button>

            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2" id="hero-dots">
                @foreach($heroBanners as $index => $banner)
                    <button class="w-2 h-2 rounded-full transition {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}"
                            data-index="{{ $index }}"></button>
                @endforeach
            </div>
        @endif
    </div>


    {{-- ================= MOBILE HERO ================= --}}
    <div class="md:hidden bg-gradient-to-br from-blue-700 to-blue-900 min-h-[400px] pb-20">
        <div class="px-4 pt-4 text-white text-center">
            <h1 class="text-2xl font-bold leading-tight">
                “Cari. Temukan. Punya Rumah.”
            </h1>

        </div>
    </div>

@else

    {{-- Kalau tidak ada banner sama sekali --}}
    <div class="md:hidden bg-gradient-to-br from-blue-700 to-blue-900 min-h-[360px] pb-20">
        <div class="px-4 pt-12 text-white text-center">
            <h1 class="text-xl font-bold">Temukan Rumah Impian Anda</h1>
            <p class="text-sm opacity-90">Ribuan properti terbaik tersedia</p>
        </div>
    </div>

@endif



    {{-- Hero Search --}}
    @include('frontend.components.hero-search')

    {{-- Banner Iklan 1 Carousel --}}
    @if(isset($ads1Banners) && $ads1Banners->count() > 0)
        <div class="max-w-[1200px] mx-auto px-4 py-4">
            <div class="relative">
                <div class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory scroll-smooth" id="ads1-scroll">
                    @foreach($ads1Banners as $banner)
                        <div class="flex-shrink-0 w-full md:w-1/2 snap-start">
                            <a href="{{ $banner->link ?? '#' }}" class="block">
                                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner Iklan 1' }}" class="w-full rounded-xl">
                            </a>
                        </div>
                    @endforeach
                </div>
                
                @if($ads1Banners->count() > 1)
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2" id="ads1-dots">
                        @foreach($ads1Banners as $index => $banner)
                            <button class="w-2 h-2 rounded-full transition {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}" data-index="{{ $index }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="max-w-[1200px] mx-auto px-4 py-4">
            <img src="https://source.unsplash.com/1200x120/?city,building" class="w-full rounded-xl" alt="Banner Iklan 1">
        </div>
    @endif

    {{-- Rekomendasi Carousel --}}
    <section class="max-w-[1200px] mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Rekomendasi Sesuai Pencarianmu</h3>
            <div class="flex gap-2">
                <button id="reco-prev" class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-gray-600 hover:bg-gray-100 transition">
                    <i class="fa fa-chevron-left text-sm"></i>
                </button>
                <button id="reco-next" class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-gray-600 hover:bg-gray-100 transition">
                    <i class="fa fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>

        {{-- Carousel Container --}}
        <div id="reco-carousel" class="relative">
            <div class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory scroll-smooth" id="reco-scroll">
                @forelse($recommendedProperties as $property)
                    <div class="flex-shrink-0 w-[280px] snap-start">
                        @include('frontend.components.property-card', ['property' => $property])
                    </div>
                @empty
                    @for($i = 0; $i < 6; $i++)
                        <div class="flex-shrink-0 w-[280px] snap-start">
                            <div class="bg-white rounded-xl shadow p-4">
                                <div class="aspect-[4/3] bg-gray-200 rounded-lg mb-3"></div>
                                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                                <div class="h-3 bg-gray-200 rounded w-2/3"></div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    {{-- Banner Iklan 2 Carousel --}}
    @if(isset($ads2Banners) && $ads2Banners->count() > 0)
        <div class="max-w-[1200px] mx-auto px-4 py-4">
            <div class="relative">
                <div class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory scroll-smooth" id="ads2-scroll">
                    @foreach($ads2Banners as $banner)
                        <div class="flex-shrink-0 w-full md:w-1/2 snap-start">
                            <a href="{{ $banner->link ?? '#' }}" class="block">
                                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner Iklan 2' }}" class="w-full rounded-xl">
                            </a>
                        </div>
                    @endforeach
                </div>
                
                @if($ads2Banners->count() > 1)
                    <button id="ads2-prev" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 shadow flex items-center justify-center text-gray-700 hover:bg-white transition z-10" style="display: none;">
                        <i class="fa fa-chevron-left text-sm"></i>
                    </button>
                    <button id="ads2-next" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 shadow flex items-center justify-center text-gray-700 hover:bg-white transition z-10" style="display: none;">
                        <i class="fa fa-chevron-right text-sm"></i>
                    </button>
                @endif
            </div>
        </div>
    @else
        <div class="max-w-[1200px] mx-auto px-4 py-4">
            <img src="https://source.unsplash.com/1200x200/?apartment" class="w-full rounded-xl" alt="Banner Iklan 2">
        </div>
    @endif

    {{-- Properti Pilihan --}}
    <section class="max-w-[1200px] mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Properti Pilihan Kami</h3>
            <div class="flex gap-2">
                <button id="choice-prev" class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-gray-600 hover:bg-gray-100 transition">
                    <i class="fa fa-chevron-left text-sm"></i>
                </button>
                <button id="choice-next" class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-gray-600 hover:bg-gray-100 transition">
                    <i class="fa fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>

        {{-- Carousel Container --}}
        <div id="choice-carousel" class="relative">
            <div class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory scroll-smooth md:grid md:grid-cols-4 md:overflow-visible md:snap-none" id="choice-scroll">
                @forelse($ourChoiceProperties as $property)
                    <div class="flex-shrink-0 w-[280px] snap-start">
                        @include('frontend.components.property-card', ['property' => $property])
                    </div>
                @empty
                    @for($i = 0; $i < 8; $i++)
                        <div class="flex-shrink-0 w-[280px] snap-start">
                            <div class="bg-white rounded-xl shadow p-4">
                                <div class="aspect-[4/3] bg-gray-200 rounded-lg mb-3"></div>
                                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                                <div class="h-3 bg-gray-200 rounded w-2/3"></div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    {{-- Banner Iklan 3 Carousel --}}
    @if(isset($ads3Banners) && $ads3Banners->count() > 0)
        @if($ads3Banners->count() == 1)
            {{-- Single Banner: Tampilkan seperti Banner Bawah --}}
            <div class="max-w-[1200px] mx-auto px-4 py-4">
                @foreach($ads3Banners as $banner)
                    <a href="{{ $banner->link ?? '#' }}" class="block">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner Iklan 3' }}" class="w-full rounded-xl">
                    </a>
                @endforeach
            </div>
        @else
            {{-- Multiple Banners: Tampilkan sebagai Carousel --}}
            <div class="max-w-[1200px] mx-auto px-4 py-4">
                <div class="relative">
                    <div class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory scroll-smooth" id="ads3-scroll">
                        @foreach($ads3Banners as $banner)
                            <div class="flex-shrink-0 w-full md:w-1/2 snap-start">
                                <a href="{{ $banner->link ?? '#' }}" class="block">
                                    <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner Iklan 3' }}" class="w-full rounded-xl">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    
                    <button id="ads3-prev" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 shadow flex items-center justify-center text-gray-700 hover:bg-white transition z-10" style="display: none;">
                        <i class="fa fa-chevron-left text-sm"></i>
                    </button>
                    <button id="ads3-next" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 shadow flex items-center justify-center text-gray-700 hover:bg-white transition z-10" style="display: none;">
                        <i class="fa fa-chevron-right text-sm"></i>
                    </button>
                </div>
            </div>
        @endif
    @else
        <div class="max-w-[1200px] mx-auto px-4 py-4">
            <img src="https://source.unsplash.com/1200x200/?house" class="w-full rounded-xl" alt="Banner Iklan 3">
        </div>
    @endif

    {{-- Properti Populer --}}
    <section class="max-w-[1200px] mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Properti Populer</h3>
            <div class="flex gap-2">
                <button id="popular-prev" class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-gray-600 hover:bg-gray-100 transition">
                    <i class="fa fa-chevron-left text-sm"></i>
                </button>
                <button id="popular-next" class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center text-gray-600 hover:bg-gray-100 transition">
                    <i class="fa fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>

        {{-- Carousel Container --}}
        <div id="popular-carousel" class="relative">
            <div class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory scroll-smooth md:grid md:grid-cols-4 md:overflow-visible md:snap-none" id="popular-scroll">
                @forelse($popularProperties as $property)
                    <div class="flex-shrink-0 w-[280px] snap-start">
                        @include('frontend.components.property-card', ['property' => $property])
                    </div>
                @empty
                    @for($i = 0; $i < 8; $i++)
                        <div class="flex-shrink-0 w-[280px] snap-start">
                            <div class="bg-white rounded-xl shadow p-4">
                                <div class="aspect-[4/3] bg-gray-200 rounded-lg mb-3"></div>
                                <div class="h-4 bg-gray-200 rounded mb-2"></div>
                                <div class="h-3 bg-gray-200 rounded w-2/3"></div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    {{-- Proyek Developer --}}
    @if(isset($developerProjects) && $developerProjects->count() > 0)
    <section class="max-w-[1200px] mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Proyek Terverifikasi</h3>
                <p class="text-sm text-gray-500 mt-1">Properti dengan info terbaru, akurat, dan diverifikasi secara berkala ke developer</p>
            </div>
            <a href="{{ route('projects') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                Lihat Semua <i class="fa fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory scroll-smooth md:grid md:grid-cols-4 md:overflow-visible md:snap-none" id="developer-scroll">
            @foreach($developerProjects as $project)
                <div class="flex-shrink-0 w-[280px] snap-start">
                    <a href="{{ route('projects.show', $project->slug ?? $project->id) }}" class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow group block">
                        <div class="aspect-[4/3] bg-gray-200 relative overflow-hidden">
                            @if(!empty($project->images) && count($project->images) > 0)
                                <img src="{{ $project->images[0] }}" 
                                     alt="{{ $project->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @elseif($project->properties->first() && $project->properties->first()->images->first())
                                <img src="{{ Storage::url($project->properties->first()->images->first()->path) }}" 
                                     alt="{{ $project->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-100">
                                    <i class="fa fa-building text-4xl text-blue-300"></i>
                                </div>
                            @endif
                            @if($project->logo)
                                <img src="{{ $project->logo }}" alt="Logo" class="absolute bottom-2 right-2 w-8 h-8 rounded-lg bg-white p-1 shadow">
                            @endif
                        </div>
                        <div class="p-3">
                            <h4 class="font-semibold text-sm text-gray-800 group-hover:text-blue-600 transition-colors line-clamp-1">{{ $project->name }}</h4>
                            @if($project->user)
                                <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $project->user->company_name ?? $project->user->name }}</p>
                            @endif
                            <div class="flex items-center justify-between mt-2">
                                <div>
                                    @if($project->price_start)
                                        <p class="text-xs font-semibold text-blue-600">
                                            Mulai Rp {{ number_format($project->price_start, 0, ',', '.') }}
                                        </p>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-400">
                                    <i class="fa fa-home mr-1"></i> {{ $project->properties_count ?? 0 }}
                                </span>
                            </div>
                            @if($project->city)
                                <p class="text-xs text-gray-400 mt-1 line-clamp-1">
                                    <i class="fa fa-map-marker-alt mr-1"></i> {{ $project->city }}
                                </p>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Tools --}}
    @include('frontend.components.tools')

    {{-- Kenapa pilih --}}
    <section class="max-w-[1200px] mx-auto px-4 py-8">
        <h3 class="text-lg font-semibold mb-6">Kenapa pilih kami?</h3>
        <div class="grid md:grid-cols-4 gap-4 text-sm">
            <div class="bg-white p-4 rounded shadow text-center">
                <i class="fa fa-home text-3xl text-blue-600 mb-2"></i>
                <h4 class="font-semibold">Banyak pilihan</h4>
                <p class="text-gray-500 mt-1">Ribuan properti tersedia</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <i class="fa fa-shield text-3xl text-green-600 mb-2"></i>
                <h4 class="font-semibold">Project terpercaya</h4>
                <p class="text-gray-500 mt-1">Developer terbaik</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <i class="fa fa-tag text-3xl text-orange-600 mb-2"></i>
                <h4 class="font-semibold">Harga transparan</h4>
                <p class="text-gray-500 mt-1">Tanpa biaya tersembunyi</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <i class="fa fa-check-circle text-3xl text-purple-600 mb-2"></i>
                <h4 class="font-semibold">Proses mudah</h4>
                <p class="text-gray-500 mt-1">Transaksi aman & cepat</p>
            </div>
        </div>
    </section>

    {{-- Testimoni --}}
    <section class="max-w-[1200px] mx-auto px-4 py-8">
        <h3 class="text-lg font-semibold mb-6">Apa kata mereka?</h3>
        <div class="grid md:grid-cols-3 gap-4">
            @forelse(($testimonials ?? collect())->take(3) as $testimonial)
                @include('frontend.components.testimonial', ['testimonial' => $testimonial])
            @empty
                @include('frontend.components.testimonial')
                @include('frontend.components.testimonial')
                @include('frontend.components.testimonial')
            @endforelse
        </div>
    </section>

    {{-- Artikel --}}
    <section class="max-w-[1200px] mx-auto px-4 py-8">
        <div class="flex justify-between mb-4">
            <h3 class="text-lg font-semibold">Info Properti</h3>
            <a href="{{ route('articles') }}" class="text-sm text-blue-600 hover:text-blue-700">Lihat lainnya</a>
        </div>
        <div class="grid md:grid-cols-4 gap-4">
            @forelse(($articles ?? collect())->take(4) as $article)
                @include('frontend.components.article-card', ['article' => $article])
            @empty
                @for($i = 0; $i < 4; $i++)
                    @include('frontend.components.article-card')
                @endfor
            @endforelse
        </div>
    </section>

    {{-- Banner Bawah --}}
    @if(isset($bottomBanners) && $bottomBanners->count() > 0)
        @if($bottomBanners->count() == 1)
            {{-- Single Banner: Tampilkan full width --}}
            <div class="max-w-[1200px] mx-auto px-4 py-6">
                @foreach($bottomBanners as $banner)
                    <a href="{{ $banner->link ?? '#' }}" class="block">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner Bawah' }}" class="w-full rounded-xl">
                    </a>
                @endforeach
            </div>
        @else
            {{-- Multiple Banners: Tampilkan sebagai Carousel --}}
            <div class="max-w-[1200px] mx-auto px-4 py-6">
                <div class="relative">
                    <div class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory scroll-smooth" id="bottom-scroll">
                        @foreach($bottomBanners as $banner)
                            <div class="flex-shrink-0 w-full md:w-1/2 snap-start">
                                <a href="{{ $banner->link ?? '#' }}" class="block">
                                    <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner Bawah' }}" class="w-full rounded-xl">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    
                    <button id="bottom-prev" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 shadow flex items-center justify-center text-gray-700 hover:bg-white transition z-10" style="display: none;">
                        <i class="fa fa-chevron-left text-sm"></i>
                    </button>
                    <button id="bottom-next" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 shadow flex items-center justify-center text-gray-700 hover:bg-white transition z-10" style="display: none;">
                        <i class="fa fa-chevron-right text-sm"></i>
                    </button>
                </div>
            </div>
        @endif
    @else
        <div class="max-w-[1200px] mx-auto px-4 py-6">
            <img src="https://source.unsplash.com/1200x250/?real-estate" class="w-full rounded-xl" alt="Banner Bawah">
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateScrollButtons(container, prevButton, nextButton) {
                const maxScroll = container.scrollWidth - container.clientWidth;
                prevButton.style.display = container.scrollLeft > 0 ? 'flex' : 'none';
                nextButton.style.display = container.scrollLeft < maxScroll - 10 ? 'flex' : 'none';
            }

            // Hero Banner Carousel
            const heroSlides = document.getElementById('hero-slides');
            const heroPrev = document.getElementById('hero-prev');
            const heroNext = document.getElementById('hero-next');
            const heroDots = document.querySelectorAll('#hero-dots button');
            
            if (heroSlides && heroPrev && heroNext) {
                let heroCurrentIndex = 0;
                const heroTotalSlides = heroSlides.children.length;
                
                function updateHeroCarousel() {
                    heroSlides.style.transform = `translateX(-${heroCurrentIndex * 100}%)`;
                    
                    heroDots.forEach((dot, index) => {
                        dot.classList.toggle('bg-white', index === heroCurrentIndex);
                        dot.classList.toggle('bg-white/50', index !== heroCurrentIndex);
                    });
                }
                
                heroPrev.addEventListener('click', () => {
                    heroCurrentIndex = (heroCurrentIndex - 1 + heroTotalSlides) % heroTotalSlides;
                    updateHeroCarousel();
                });
                
                heroNext.addEventListener('click', () => {
                    heroCurrentIndex = (heroCurrentIndex + 1) % heroTotalSlides;
                    updateHeroCarousel();
                });
                
                heroDots.forEach((dot, index) => {
                    dot.addEventListener('click', () => {
                        heroCurrentIndex = index;
                        updateHeroCarousel();
                    });
                });
                
                // Auto-slide every 5 seconds
                setInterval(() => {
                    heroCurrentIndex = (heroCurrentIndex + 1) % heroTotalSlides;
                    updateHeroCarousel();
                }, 5000);
            }

            // Rekomendasi Carousel
            const scrollContainer = document.getElementById('reco-scroll');
            const prevBtn = document.getElementById('reco-prev');
            const nextBtn = document.getElementById('reco-next');
            const cardWidth = 280 + 16; // card width + gap

            if (scrollContainer && prevBtn && nextBtn) {
                nextBtn.addEventListener('click', () => {
                    scrollContainer.scrollBy({ left: cardWidth, behavior: 'smooth' });
                });

                prevBtn.addEventListener('click', () => {
                    scrollContainer.scrollBy({ left: -cardWidth, behavior: 'smooth' });
                });

                // Hide/show buttons based on scroll position
                const updateRecoButtons = () => updateScrollButtons(scrollContainer, prevBtn, nextBtn);
                scrollContainer.addEventListener('scroll', updateRecoButtons);
                window.addEventListener('resize', updateRecoButtons);
                window.addEventListener('load', updateRecoButtons);
                requestAnimationFrame(updateRecoButtons);
            }

            // Ads1 Banner Carousel
            const ads1Scroll = document.getElementById('ads1-scroll');
            const ads1Prev = document.getElementById('ads1-prev');
            const ads1Next = document.getElementById('ads1-next');

            if (ads1Scroll && ads1Prev && ads1Next) {
                const ads1Width = (ads1Scroll.firstElementChild?.offsetWidth || 600) + 16; // banner width + gap

                ads1Next.addEventListener('click', () => {
                    ads1Scroll.scrollBy({ left: ads1Width, behavior: 'smooth' });
                });

                ads1Prev.addEventListener('click', () => {
                    ads1Scroll.scrollBy({ left: -ads1Width, behavior: 'smooth' });
                });

                // Hide/show buttons based on scroll position
                const updateAds1Buttons = () => updateScrollButtons(ads1Scroll, ads1Prev, ads1Next);
                ads1Scroll.addEventListener('scroll', updateAds1Buttons);
                window.addEventListener('resize', updateAds1Buttons);
                window.addEventListener('load', updateAds1Buttons);
                requestAnimationFrame(updateAds1Buttons);
            }

            // Ads2 Banner Carousel
            const ads2Scroll = document.getElementById('ads2-scroll');
            const ads2Prev = document.getElementById('ads2-prev');
            const ads2Next = document.getElementById('ads2-next');

            if (ads2Scroll && ads2Prev && ads2Next) {
                const ads2Width = (ads2Scroll.firstElementChild?.offsetWidth || 600) + 16; // banner width + gap

                ads2Next.addEventListener('click', () => {
                    ads2Scroll.scrollBy({ left: ads2Width, behavior: 'smooth' });
                });

                ads2Prev.addEventListener('click', () => {
                    ads2Scroll.scrollBy({ left: -ads2Width, behavior: 'smooth' });
                });

                // Hide/show buttons based on scroll position
                const updateAds2Buttons = () => updateScrollButtons(ads2Scroll, ads2Prev, ads2Next);
                ads2Scroll.addEventListener('scroll', updateAds2Buttons);
                window.addEventListener('resize', updateAds2Buttons);
                window.addEventListener('load', updateAds2Buttons);
                requestAnimationFrame(updateAds2Buttons);
            }

            // Ads3 Banner Carousel (only if more than 1 banner)
            const ads3Scroll = document.getElementById('ads3-scroll');
            const ads3Prev = document.getElementById('ads3-prev');
            const ads3Next = document.getElementById('ads3-next');

            if (ads3Scroll && ads3Prev && ads3Next) {
                const ads3Width = (ads3Scroll.firstElementChild?.offsetWidth || 600) + 16; // banner width + gap

                ads3Next.addEventListener('click', () => {
                    ads3Scroll.scrollBy({ left: ads3Width, behavior: 'smooth' });
                });

                ads3Prev.addEventListener('click', () => {
                    ads3Scroll.scrollBy({ left: -ads3Width, behavior: 'smooth' });
                });

                // Hide/show buttons based on scroll position
                const updateAds3Buttons = () => updateScrollButtons(ads3Scroll, ads3Prev, ads3Next);
                ads3Scroll.addEventListener('scroll', updateAds3Buttons);
                window.addEventListener('resize', updateAds3Buttons);
                window.addEventListener('load', updateAds3Buttons);
                requestAnimationFrame(updateAds3Buttons);
            }

            // Banner Bawah Carousel (only if more than 1 banner)
            const bottomScroll = document.getElementById('bottom-scroll');
            const bottomPrev = document.getElementById('bottom-prev');
            const bottomNext = document.getElementById('bottom-next');

            if (bottomScroll && bottomPrev && bottomNext) {
                const bottomWidth = (bottomScroll.firstElementChild?.offsetWidth || 600) + 16; // banner width + gap

                bottomNext.addEventListener('click', () => {
                    bottomScroll.scrollBy({ left: bottomWidth, behavior: 'smooth' });
                });

                bottomPrev.addEventListener('click', () => {
                    bottomScroll.scrollBy({ left: -bottomWidth, behavior: 'smooth' });
                });

                // Hide/show buttons based on scroll position
                const updateBottomButtons = () => updateScrollButtons(bottomScroll, bottomPrev, bottomNext);
                bottomScroll.addEventListener('scroll', updateBottomButtons);
                window.addEventListener('resize', updateBottomButtons);
                window.addEventListener('load', updateBottomButtons);
                requestAnimationFrame(updateBottomButtons);
            }

            // Properti Pilihan Carousel
            const choiceScroll = document.getElementById('choice-scroll');
            const choicePrev = document.getElementById('choice-prev');
            const choiceNext = document.getElementById('choice-next');
            const choiceCardWidth = 280 + 16; // card width + gap

            if (choiceScroll && choicePrev && choiceNext) {
                choiceNext.addEventListener('click', () => {
                    choiceScroll.scrollBy({ left: choiceCardWidth, behavior: 'smooth' });
                });

                choicePrev.addEventListener('click', () => {
                    choiceScroll.scrollBy({ left: -choiceCardWidth, behavior: 'smooth' });
                });

                const updateChoiceButtons = () => updateScrollButtons(choiceScroll, choicePrev, choiceNext);
                choiceScroll.addEventListener('scroll', updateChoiceButtons);
                window.addEventListener('resize', updateChoiceButtons);
                window.addEventListener('load', updateChoiceButtons);
                requestAnimationFrame(updateChoiceButtons);
            }

            // Properti Populer Carousel
            const popularScroll = document.getElementById('popular-scroll');
            const popularPrev = document.getElementById('popular-prev');
            const popularNext = document.getElementById('popular-next');

            if (popularScroll && popularPrev && popularNext) {
                popularNext.addEventListener('click', () => {
                    popularScroll.scrollBy({ left: choiceCardWidth, behavior: 'smooth' });
                });

                popularPrev.addEventListener('click', () => {
                    popularScroll.scrollBy({ left: -choiceCardWidth, behavior: 'smooth' });
                });

                const updatePopularButtons = () => updateScrollButtons(popularScroll, popularPrev, popularNext);
                popularScroll.addEventListener('scroll', updatePopularButtons);
                window.addEventListener('resize', updatePopularButtons);
                window.addEventListener('load', updatePopularButtons);
                requestAnimationFrame(updatePopularButtons);
            }

            // Proyek Developer Carousel
            const developerScroll = document.getElementById('developer-scroll');

            if (developerScroll) {
                const updateDeveloperButtons = () => {
                    const maxScroll = developerScroll.scrollWidth - developerScroll.clientWidth;
                    // Hide prev/next buttons on desktop since it's a grid
                    if (window.innerWidth >= 768) {
                        if (choicePrev) choicePrev.style.display = 'none';
                        if (choiceNext) choiceNext.style.display = 'none';
                        if (popularPrev) popularPrev.style.display = 'none';
                        if (popularNext) popularNext.style.display = 'none';
                    }
                };
                developerScroll.addEventListener('scroll', updateDeveloperButtons);
                window.addEventListener('resize', updateDeveloperButtons);
                window.addEventListener('load', updateDeveloperButtons);
                requestAnimationFrame(updateDeveloperButtons);
            }
        });
    </script>
@endsection

