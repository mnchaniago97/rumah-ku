@extends('frontend.layouts.app')

@section('content')
    @php
        /** @var \App\Models\User $agent */
        $avatar = $agent->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($agent->name) . '&background=random&color=fff&size=256';
        $phoneDigits = preg_replace('/[^0-9]/', '', (string) ($agent->whatsapp_phone ?? $agent->phone ?? ''));
        $wa = $phoneDigits ? 'https://wa.me/' . $phoneDigits : null;
    @endphp

    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4 space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-sm flex flex-col md:flex-row gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-full bg-gray-200 overflow-hidden">
                        <img src="{{ $avatar }}" alt="{{ $agent->name }}" class="w-full h-full object-cover" loading="lazy">
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $agent->name }}</h1>
                        <p class="text-sm text-gray-500">{{ $agent->published_properties_count ?? 0 }} properti aktif</p>
                    </div>
                </div>
                <div class="flex-1 flex items-start md:items-center justify-end gap-2">
                    <a href="{{ route('agents') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <a @if($wa) href="{{ $wa }}" target="_blank" rel="noopener" @else aria-disabled="true" @endif
                        class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition {{ $wa ? '' : 'opacity-50 pointer-events-none' }}">
                        Hubungi (WA)
                    </a>
                </div>
            </div>

            @if(filled($agent->bio))
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-2">Tentang Agent</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $agent->bio }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900">Properti</h2>
                </div>

                @if($properties->count() === 0)
                    <div class="rounded-xl border border-dashed border-gray-200 bg-white p-6 text-center text-sm text-gray-500">
                        Agent ini belum memiliki properti yang dipublikasikan.
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($properties as $property)
                            @php
                                $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                                    ?? $property->images->sortBy('sort_order')->first()?->path
                                    ?? 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=512';

                                if (!empty($cardImage) && !str_starts_with($cardImage, 'http://') && !str_starts_with($cardImage, 'https://') && !str_starts_with($cardImage, '/')) {
                                    $cardImage = '/storage/' . ltrim($cardImage, '/');
                                }
                            @endphp

                            <a href="{{ route('property.show', $property->slug) }}" class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition block">
                                <div class="relative flex h-44 justify-center overflow-hidden rounded-lg">
                                    <div class="w-full transform transition-transform duration-500 ease-in-out hover:scale-110">
                                        <img src="{{ $cardImage }}" alt="{{ $property->title }}" class="h-full w-full object-cover" loading="lazy" />
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h3 class="line-clamp-1 text-base font-semibold text-gray-900" title="{{ $property->title }}">
                                        {{ $property->title }}
                                    </h3>
                                    <p class="mt-2 text-blue-700 font-semibold">
                                        Rp {{ $property->price ? number_format($property->price, 0, ',', '.') : '0' }}
                                    </p>
                                    <p class="mt-2 text-sm text-gray-500">
                                        <i class="fa fa-map-marker mr-1 text-gray-400"></i>
                                        {{ $property->city ?? '-' }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $properties->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
