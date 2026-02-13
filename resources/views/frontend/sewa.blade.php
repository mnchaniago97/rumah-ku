@extends('frontend.layouts.app')

@push('styles')
<style>
    .filter-checkbox:checked + label {
        background-color: #16a34a;
        border-color: #16a34a;
        color: white;
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<section class="bg-gray-100 dark:bg-gray-900 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Properti Disewa</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Temukan rumah, kos, ruko, villa, apartemen dan lainnya untuk disewa</p>
    </div>
</section>

<!-- Content Section -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-1/4">
                <form action="{{ route('sewa') }}" method="GET" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filter Pencarian</h3>
                    
                    <!-- Tipe Properti -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Tipe Properti</h4>
                        <div class="space-y-2">
                            @foreach(['Rumah' => 'Rumah', 'Apartemen' => 'Apartemen', 'Villa' => 'Villa', 'Ruko' => 'Ruko'] as $value => $label)
                                <div class="flex items-center">
                                    <input type="radio" name="type" value="{{ $value }}" id="type-{{ $value }}"
                                        class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                                        {{ request('type') === $value ? 'checked' : '' }}>
                                    <label for="type-{{ $value }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">
                                        {{ $label }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kisaran Harga -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Kisaran Harga</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Min (Rp)</label>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="500rb"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Max (Rp)</label>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="5jt"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Kamar -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Kamar</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Kamar Tidur</label>
                                <select name="bedrooms" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Semua</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>{{ $i }} KT</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 dark:text-gray-400">Kamar Mandi</label>
                                <select name="bathrooms" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Semua</option>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}" {{ request('bathrooms') == $i ? 'selected' : '' }}>{{ $i }} KM</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Fasilitas -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Fasilitas</h4>
                        <div class="space-y-2">
                            @foreach([
                                'ac' => 'AC',
                                'furnished' => 'Furnished',
                                'carport' => 'Carport',
                                'garage' => 'Garasi',
                                'garden' => 'Taman',
                                'pool' => 'Kolam Renang',
                                'security' => 'Security 24 Jam',
                                'cctv' => 'CCTV'
                            ] as $value => $label)
                                <div class="flex items-center">
                                    <input type="checkbox" name="facilities[]" value="{{ $value }}" id="facility-{{ $value }}"
                                        class="hidden">
                                    <label for="facility-{{ $value }}" 
                                        class="flex items-center gap-2 px-3 py-2 text-sm border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
                                        <span class="w-4 h-4 border border-gray-300 rounded flex items-center justify-center">
                                            <i class="fa fa-check text-xs opacity-0"></i>
                                        </span>
                                        {{ $label }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-700 transition-colors">
                            Terapkan
                        </button>
                        <a href="{{ route('sewa') }}" class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-300 transition-colors text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </aside>

            <!-- Property Listings -->
            <div class="w-full lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-600 dark:text-gray-400">
                        Menampilkan <span class="font-semibold text-gray-900 dark:text-white">{{ $properties->count() }}</span> 
                        dari <span class="font-semibold text-gray-900 dark:text-white">{{ $properties->total() }}</span> properti
                    </p>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="latest">Terbaru</option>
                        <option value="price_low">Harga: Termurah</option>
                        <option value="price_high">Harga: Termahal</option>
                    </select>
                </div>

                @if($properties->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($properties as $property)
                            @php
                                $primaryImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)
                                    ?? $property->images->sortBy('sort_order')->first();
                                $imageUrl = $primaryImage 
                                    ? Storage::url(str_replace('/storage/', '', $primaryImage->path))
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=512';
                            @endphp
                            <article class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <div class="relative">
                                    <img src="{{ $imageUrl }}" alt="{{ $property->title }}" 
                                        class="w-full h-48 object-cover">
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">
                                            {{ $property->type ?? 'Rumah' }}
                                        </span>
                                    </div>
                                    <div class="absolute bottom-3 left-3">
                                        <span class="bg-white/90 text-gray-800 text-xs font-semibold px-2 py-1 rounded flex items-center gap-1">
                                            <i class="fa fa-camera"></i> {{ $property->images->count() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg line-clamp-1" title="{{ $property->title }}">
                                        {{ $property->title }}
                                    </h3>
                                    <p class="text-green-600 font-bold text-lg mt-1">
                                        Rp {{ number_format($property->price, 0, ',', '.') }}
                                        <span class="text-xs font-normal text-gray-500">/bulan</span>
                                    </p>
                                    <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm mt-2">
                                        <i class="fa fa-map-marker"></i>
                                        <span class="line-clamp-1">{{ $property->city ?? $property->address ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-4 mt-3 text-gray-600 dark:text-gray-300">
                                        <span class="flex items-center gap-1 text-sm">
                                            <i class="fa fa-bed"></i> {{ $property->bedrooms ?? 0 }} KT
                                        </span>
                                        <span class="flex items-center gap-1 text-sm">
                                            <i class="fa fa-bath"></i> {{ $property->bathrooms ?? 0 }} KM
                                        </span>
                                        <span class="flex items-center gap-1 text-sm">
                                            <i class="fa fa-expand"></i> {{ $property->building_area ?? $property->land_area ?? 0 }} m²
                                        </span>
                                    </div>
                                    <a href="{{ route('property.show', $property->permalink ?? $property->id) }}" 
                                        class="block mt-4 text-center bg-green-600 text-white py-2 rounded-lg font-medium hover:bg-green-700 transition-colors">
                                        Lihat Detail
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $properties->links() }}
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center">
                        <i class="fa fa-home text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tidak Ada Properti Tersedia</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Maaf, tidak ada properti yang tersedia untuk disewa saat ini.</p>
                        <a href="{{ route('rumah-subsidi') }}" class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors">
                            Lihat Rumah Subsidi
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Toggle checkbox styling
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const label = this.nextElementSibling;
            const checkmark = label.querySelector('.fa-check');
            if (this.checked) {
                label.classList.add('bg-green-600', 'border-green-600', 'text-white');
                label.classList.remove('border-gray-300', 'text-gray-700', 'dark:text-gray-300');
                checkmark.classList.remove('opacity-0');
            } else {
                label.classList.remove('bg-green-600', 'border-green-600', 'text-white');
                label.classList.add('border-gray-300', 'text-gray-700', 'dark:text-gray-300');
                checkmark.classList.add('opacity-0');
            }
        });
    });
</script>
@endpush
