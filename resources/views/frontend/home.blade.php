@extends('frontend.layouts.app')

@section('content')
    {{-- Hero Banner --}}
    @if(isset($heroBanners) && $heroBanners->count() > 0)
        <div class="relative">
            <div id="hero-carousel" class="overflow-hidden rounded-b-[40px] mx-[50px]">
                <div class="flex transition-transform duration-500 ease-in-out" id="hero-slides">
                    @foreach($heroBanners as $index => $banner)
                        <div class="w-full flex-shrink-0">
                            <a href="{{ $banner->link ?? '#' }}" class="block">
                                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Hero Banner' }}" class="w-full object-cover">
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
                        <button class="w-2 h-2 rounded-full transition {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}" data-index="{{ $index }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <div class="max-w-[1200px] mx-auto px-4 py-8 hidden md:block">
            <div class="w-full md:w-4/12 bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl flex items-center justify-center">
                <div class="text-center text-white py-12 px-6">
                    <h1 class="text-2xl md:text-3xl font-bold mb-2">Temukan Rumah Impian Anda</h1>
                    <p class="text-sm md:text-base">ribuan properti terbaik tersedia</p>
                </div>
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
    <section class="max-w-[1200px] mx-auto px-4 py-8">
        <h3 class="text-lg font-semibold mb-4">Properti Pilihan Kami</h3>
        <div class="grid md:grid-cols-2 gap-6">
            @forelse($ourChoiceProperties as $property)
                @include('frontend.components.project-card', ['property' => $property])
            @empty
                @for($i = 0; $i < 4; $i++)
                    <div class="bg-white rounded-xl shadow overflow-hidden">
                        <div class="aspect-[16/9] bg-gray-200"></div>
                        <div class="p-4">
                            <div class="h-4 bg-gray-200 rounded mb-2"></div>
                            <div class="h-3 bg-gray-200 rounded w-2/3"></div>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>
    </section>

    {{-- Banner Iklan 3 --}}
    @if(isset($ads3Banners) && $ads3Banners->count() > 0)
        <div class="max-w-[1200px] mx-auto px-4 py-4">
            <div class="grid gap-4 {{ $ads3Banners->count() > 1 ? 'grid-cols-2' : 'grid-cols-1' }}">
                @foreach($ads3Banners as $banner)
                    <a href="{{ $banner->link ?? '#' }}" class="block">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner Iklan 3' }}" class="w-full rounded-xl">
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Properti Populer --}}
    <section class="max-w-[1200px] mx-auto px-4 py-8">
        <h3 class="text-lg font-semibold mb-4">Properti Populer</h3>
        <div class="grid md:grid-cols-3 gap-4">
            @forelse($popularProperties as $property)
                @include('frontend.components.property-card', ['property' => $property])
            @empty
                @for($i = 0; $i < 6; $i++)
                    <div class="bg-white rounded-xl shadow p-4">
                        <div class="aspect-[4/3] bg-gray-200 rounded-lg mb-3"></div>
                        <div class="h-4 bg-gray-200 rounded mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-2/3"></div>
                    </div>
                @endfor
            @endforelse
        </div>
    </section>

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
        <div class="max-w-[1200px] mx-auto px-4 py-6">
            <div class="grid gap-4 {{ $bottomBanners->count() > 1 ? 'grid-cols-2' : 'grid-cols-1' }}">
                @foreach($bottomBanners as $banner)
                    <a href="{{ $banner->link ?? '#' }}" class="block">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner Bawah' }}" class="w-full rounded-xl">
                    </a>
                @endforeach
            </div>
        </div>
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
        });
    </script>
@endsection

