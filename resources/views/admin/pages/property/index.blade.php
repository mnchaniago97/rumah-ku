@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Property</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola listing property.</p>
            </div>
            <a href="{{ route('admin.properties.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                + Tambah Property
            </a>
        </div>

        <div class="grid w-full grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($properties as $property)
                @php
                    $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                        ?? $property->images->sortBy('sort_order')->first()?->path
                        ?? 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=512';
                    
                    $bedrooms = $property->bedrooms ?? 0;
                    $bathrooms = $property->bathrooms ?? 0;
                    $area = $property->land_area ?? $property->building_area ?? 0;
                @endphp
                <div class="relative mx-auto w-full">
                    <a href="{{ route('admin.properties.show', $property) }}" class="relative inline-block w-full transform transition-transform duration-300 ease-in-out hover:-translate-y-2">
                        <div class="rounded-lg bg-white p-4 shadow">
                            <div class="relative flex h-52 justify-center overflow-hidden rounded-lg">
                                <div class="w-full transform transition-transform duration-500 ease-in-out hover:scale-110">
                                    <div class="absolute inset-0 bg-black bg-opacity-80">
                                        <img src="{{ $cardImage }}" alt="{{ $property->title }}" />
                                    </div>
                                </div>

                                <div class="absolute bottom-0 left-5 mb-3 flex">
                                    <p class="flex items-center font-medium text-white shadow-sm">
                                        <i class="fa fa-camera mr-2 text-xl text-white"></i>
                                        {{ $property->images->count() }}
                                    </p>
                                </div>
                                <div class="absolute bottom-0 right-5 mb-3 flex">
                                    <p class="flex items-center font-medium text-gray-800">
                                        <i class="fa fa-heart mr-2 text-2xl text-white"></i>
                                    </p>
                                </div>

                    <span class="absolute top-0 right-2 z-10 mt-3 ml-3 inline-flex select-none rounded-sm bg-[#1f93ff] px-2 py-1 text-xs font-semibold text-white">
                        {{ $property->type ?? 'Residential' }}
                    </span>
                    @if(!$property->is_approved)
                        <span class="absolute top-0 left-2 z-10 mt-3 inline-flex select-none rounded-sm bg-yellow-500 px-2 py-1 text-xs font-semibold text-white">
                            Pending Approval
                        </span>
                    @endif
                                <span class="absolute top-0 left-0 z-10 mt-3 ml-3 inline-flex select-none rounded-lg bg-transparent px-3 py-2 text-lg font-medium text-white">
                                    <i class="fa fa-star"></i>
                                </span>
                            </div>

                            <div class="mt-4">
                                <h2 class="line-clamp-1 text-2xl font-medium text-gray-800 md:text-lg" title="{{ $property->title }}">
                                    {{ $property->title }}
                                </h2>
                                @if(($property->listingCategories ?? collect())->count() > 0)
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        @foreach($property->listingCategories->sortBy('sort_order')->take(3) as $cat)
                                            <span class="rounded-full bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700">{{ $cat->name }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <p class="text-primary mt-2 inline-block whitespace-nowrap rounded-xl font-semibold leading-tight">
                                    <span class="text-sm uppercase">Rp</span>
                                    <span class="text-2xl">{{ $property->price ? number_format($property->price, 0, ',', '.') : '0' }}</span>
                                </p>
                            </div>
                            <div class="mt-4">
                                <p class="line-clamp-1 mt-2 text-lg text-gray-800">{{ $property->address ?? 'Alamat belum diisi' }}</p>
                            </div>
                            <div class="justify-center">
                                <div class="mt-4 flex flex-wrap gap-3 overflow-hidden rounded-lg px-1 py-1">
                                    <p class="flex items-center font-medium text-gray-800">
                                        <i class="fa fa-bed mr-2 text-blue-900"></i>
                                        {{ $bedrooms }}
                                    </p>

                                    <p class="flex items-center font-medium text-gray-800">
                                        <i class="fa fa-bath mr-2 text-blue-900"></i>
                                        {{ $bathrooms }}
                                    </p>
                                    <p class="flex items-center font-medium text-gray-800">
                                        <i class="fa fa-home mr-2 text-blue-900"></i>
                                        {{ $area }} m<sup>2</sup>
                                    </p>
                                </div>
                                <div class="mt-2 flex flex-wrap gap-3 overflow-hidden rounded-lg px-1 py-1">
                                    @if($property->electricity)
                                    <p class="flex items-center font-medium text-gray-800">
                                        <i class="fa fa-bolt mr-2 text-yellow-500"></i>
                                        {{ $property->electricity }} Watt
                                    </p>
                                    @endif
                                    @if($property->water_source)
                                    <p class="flex items-center font-medium text-gray-800">
                                        <i class="fa fa-tint mr-2 text-blue-500"></i>
                                        {{ $property->water_source }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-8 grid grid-cols-2">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <div class="h-6 w-6 rounded-full bg-gray-200 md:h-8 md:w-8">
                                            @if($property->user && $property->user->photo)
                                                <img src="{{ $property->user->photo }}" alt="{{ $property->user->name }}" class="h-6 w-6 rounded-full md:h-8 md:w-8 object-cover">
                                            @endif
                                        </div>
                                        <span class="bg-primary-red absolute top-0 right-0 inline-block h-3 w-3 rounded-full"></span>
                                    </div>

                                    <p class="line-clamp-1 ml-2 text-gray-800">{{ $property->user?->name ?? 'Admin' }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full rounded-xl border border-dashed border-gray-200 bg-white p-6 text-center text-sm text-gray-500 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400">
                    Belum ada data property.
                </div>
            @endforelse
        </div>
    </div>
@endsection
