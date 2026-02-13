<a href="{{ route('property.show', $property->slug ?: $property->getKey()) }}" class="block bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition group">
    <div class="aspect-[4/3] bg-gray-200 relative">
        @php
            $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                ?? $property->images->sortBy('sort_order')->first()?->path
                ?? '/assets/admin/images/product/product-01.jpg';
        @endphp
        <img src="{{ $cardImage }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
        @if($property->status)
            <span class="absolute top-3 right-3 rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white">
                {{ ucwords($property->status) }}
            </span>
        @endif
    </div>
    <div class="p-4">
        <p class="text-lg font-bold text-blue-600">
            {{ $property->price ? 'Rp ' . number_format($property->price, 0, ',', '.') : 'Hubungi Kami' }}
        </p>
        <h3 class="mt-2 line-clamp-1 text-sm font-semibold text-gray-900 group-hover:text-blue-600">
            {{ $property->title }}
        </h3>
        <p class="mt-1 text-xs text-gray-500">
            <i class="fa fa-map-marker mr-1"></i>
            {{ $property->city ?? '-' }}, {{ $property->province ?? '-' }}
        </p>
        
        <div class="mt-4 flex items-center gap-4 text-xs text-gray-600">
            @if($property->bedrooms)
            <span class="flex items-center gap-1">
                <i class="fa fa-bed text-blue-900"></i>
                {{ $property->bedrooms }} KT
            </span>
            @endif
            @if($property->bathrooms)
            <span class="flex items-center gap-1">
                <i class="fa fa-bath text-blue-900"></i>
                {{ $property->bathrooms }} KM
            </span>
            @endif
            @if($property->land_area)
            <span class="flex items-center gap-1">
                <i class="fa fa-expand text-blue-900"></i>
                {{ $property->land_area }} m²
            </span>
            @endif
        </div>
    </div>
</a>
