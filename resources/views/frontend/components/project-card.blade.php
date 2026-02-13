<a href="{{ isset($property) ? route('property.show', $property->slug ?: $property->getKey()) : '#' }}" class="block bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition">
    <div class="aspect-[16/9] bg-gray-200 relative">
        @if(isset($property) && $property->images->count() > 0)
            @php
                $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                    ?? $property->images->sortBy('sort_order')->first()?->path;
            @endphp
            <img src="{{ $cardImage }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
        @else
            <img src="/assets/admin/images/grid-image/image-01.png" alt="Project" class="w-full h-full object-cover">
        @endif
    </div>
    <div class="p-4">
        @if(isset($property))
            <h4 class="font-semibold text-gray-900 line-clamp-1">{{ $property->title }}</h4>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fa fa-map-marker mr-1"></i>
                {{ $property->city ?? 'Indonesia' }}
            </p>
        @else
            <h4 class="font-semibold text-gray-900">Nama Proyek</h4>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fa fa-map-marker mr-1"></i>
                Lokasi Proyek
            </p>
        @endif
        <div class="mt-3 flex items-center gap-2">
            <span class="rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-600">
                Rumah
            </span>
            <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-600">
                50 Unit
            </span>
        </div>
    </div>
</a>
