@php
    $wrapLink = $wrapLink ?? true;
    $showWhatsApp = $showWhatsApp ?? false;
    $showPricePeriod = $showPricePeriod ?? false;

    $cardHref = route('property.show', $property->slug ?: $property->getKey());

    $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
        ?? $property->images->sortBy('sort_order')->first()?->path
        ?? '/assets/admin/images/product/product-01.jpg';

    $periodLabel = null;
    if ($showPricePeriod && filled($property->price_period ?? null)) {
        $periodLabel = ($property->price_period === 'bulan') ? 'per bulan' : (($property->price_period === 'tahun') ? 'per tahun' : $property->price_period);
    }

    $waUrl = null;
    if ($showWhatsApp) {
        $sourcePhone = $property->whatsapp_phone ?? $property->user?->phone ?? $property->agent?->phone ?? null;
        $digits = preg_replace('/\\D+/', '', (string) $sourcePhone);
        if ($digits !== '') {
            if (str_starts_with($digits, '0')) {
                $digits = '62' . substr($digits, 1);
            } elseif (str_starts_with($digits, '8')) {
                $digits = '62' . $digits;
            }
            $waUrl = $digits ? "https://wa.me/$digits" : null;
        }
    }
@endphp

@if($wrapLink)
    <a href="{{ $cardHref }}" class="block bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition group">
        <div class="aspect-[4/3] bg-gray-200 relative">
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
                @if($periodLabel)
                    <span class="ml-1 text-xs font-semibold text-gray-500">{{ $periodLabel }}</span>
                @endif
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
@else
    <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition group">
        <a href="{{ $cardHref }}" class="block">
            <div class="aspect-[4/3] bg-gray-200 relative">
                <img src="{{ $cardImage }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                @if($property->status)
                    <span class="absolute top-3 right-3 rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white">
                        {{ ucwords($property->status) }}
                    </span>
                @endif
            </div>
        </a>

        <div class="p-4">
            <p class="text-lg font-bold text-blue-600">
                {{ $property->price ? 'Rp ' . number_format($property->price, 0, ',', '.') : 'Hubungi Kami' }}
                @if($periodLabel)
                    <span class="ml-1 text-xs font-semibold text-gray-500">{{ $periodLabel }}</span>
                @endif
            </p>
            <a href="{{ $cardHref }}" class="mt-2 block line-clamp-1 text-sm font-semibold text-gray-900 group-hover:text-blue-600">
                {{ $property->title }}
            </a>
            <p class="mt-1 text-xs text-gray-500">
                <i class="fa fa-map-marker mr-1"></i>
                {{ $property->city ?? '-' }}, {{ $property->province ?? '-' }}
            </p>

            <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-gray-600">
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

            @if($waUrl)
                <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                    class="mt-4 flex h-10 items-center justify-center gap-2 rounded-xl bg-green-600 text-sm font-semibold text-white hover:bg-green-700">
                    <i class="fa-brands fa-whatsapp"></i> WhatsApp
                </a>
            @endif
        </div>
    </div>
@endif
