@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Properti Sewa</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola listing properti sewa Anda.</p>
            </div>
            <div class="flex items-center gap-3">
                <!-- View Toggle -->
                <div class="inline-flex rounded-lg border border-gray-200 bg-white p-1 dark:border-gray-800 dark:bg-gray-900">
                    <button type="button" onclick="setView('card')" id="btn-card-view" 
                        class="inline-flex items-center gap-1 rounded-md px-3 py-1.5 text-sm font-medium transition-colors">
                        <i class="fa fa-th-large"></i>
                        Card
                    </button>
                    <button type="button" onclick="setView('table')" id="btn-table-view"
                        class="inline-flex items-center gap-1 rounded-md px-3 py-1.5 text-sm font-medium transition-colors">
                        <i class="fa fa-list"></i>
                        Table
                    </button>
                </div>
                <a href="{{ route('agent.sewa.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-green-700">
                    + Tambah Properti Sewa
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card View -->
        <div id="card-view" class="grid w-full grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($properties as $property)
                @php
                    $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                        ?? $property->images->sortBy('sort_order')->first()?->path
                        ?? 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=512';

                    if (!empty($cardImage) && !str_starts_with($cardImage, 'http://') && !str_starts_with($cardImage, 'https://') && !str_starts_with($cardImage, '/')) {
                        $cardImage = '/storage/' . ltrim($cardImage, '/');
                    }
                    
                    $bedrooms = filled($property->bedrooms) ? $property->bedrooms : '-';
                    $bathrooms = filled($property->bathrooms) ? $property->bathrooms : '-';
                    $area = $property->land_area ?? $property->building_area;
                    $pricePeriod = $property->price_period ? '/ ' . $property->price_period : '';
                @endphp
                <div class="relative w-full">
                    <div class="relative inline-block w-full transform transition-transform duration-300 ease-in-out hover:-translate-y-2">
                        <div class="rounded-lg bg-white p-4 shadow">
                            <a href="{{ route('agent.sewa.show', $property->id ?? $property->getKey()) }}"
                                class="block rounded-lg focus:outline-hidden focus:ring-2 focus:ring-green-500/40">
                                <div class="relative flex h-52 justify-center overflow-hidden rounded-lg">
                                    <div class="w-full transform transition-transform duration-500 ease-in-out hover:scale-110">
                                        <img src="{{ $cardImage }}" alt="{{ $property->title }}" class="h-full w-full object-cover" loading="lazy" />
                                    </div>

                                    <div class="pointer-events-none absolute inset-x-0 bottom-0 h-20 bg-gradient-to-t from-black/60 to-transparent"></div>

                                    <div class="absolute bottom-0 left-5 mb-3 flex">
                                        <p class="flex items-center font-medium text-white shadow-sm">
                                            <i class="fa fa-camera mr-2 text-xl text-white"></i>
                                            {{ $property->images->count() }}
                                        </p>
                                    </div>

                                    <span class="absolute top-0 right-2 z-10 mt-3 ml-3 inline-flex select-none rounded-sm bg-blue-600 px-2 py-1 text-xs font-semibold text-white">
                                        Sewa
                                    </span>
                                    
                                    @if($property->is_published)
                                        <span class="absolute top-0 left-2 z-10 mt-3 inline-flex select-none rounded-sm bg-green-500 px-2 py-1 text-xs font-semibold text-white">
                                            Published
                                        </span>
                                    @else
                                        <span class="absolute top-0 left-2 z-10 mt-3 inline-flex select-none rounded-sm bg-gray-500 px-2 py-1 text-xs font-semibold text-white">
                                            Unpublished
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <h2 class="line-clamp-1 text-2xl font-medium text-gray-800 md:text-lg" title="{{ $property->title }}">
                                        {{ $property->title }}
                                    </h2>
                                    <p class="text-primary mt-2 inline-block whitespace-nowrap rounded-xl font-semibold leading-tight">
                                        <span class="text-sm uppercase">Rp</span>
                                        <span class="text-2xl">{{ $property->price ? number_format($property->price, 0, ',', '.') : '0' }}</span>
                                        <span class="text-sm">{{ $pricePeriod }}</span>
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <p class="line-clamp-1 mt-2 text-lg text-gray-800">
                                        <i class="fa fa-map-marker mr-2 text-gray-400"></i>
                                        {{ $property->city ?? 'Belum diisi' }}
                                    </p>
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
                                            <i class="fa fa-expand mr-2 text-blue-900"></i>
                                            {{ $area ?? '-' }} m²
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="mt-6 flex gap-2">
                                <a href="{{ route('agent.sewa.edit', $property->id ?? $property->getKey()) }}"
                                    class="flex-1 rounded-lg bg-blue-600 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-blue-700">
                                    <i class="fa fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('agent.sewa.destroy', $property->id ?? $property->getKey()) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus properti sewa ini?')">
                                        <i class="fa fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-xl border border-dashed border-gray-200 bg-white p-6 text-center text-sm text-gray-500 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400">
                    <i class="fa fa-home text-4xl text-gray-300 mb-3"></i>
                    <p>Belum ada properti sewa.</p>
                    <a href="{{ route('agent.sewa.create') }}" class="inline-block mt-3 text-blue-600 hover:underline">
                        Tambah Properti Sewa Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Table View -->
        <div id="table-view" class="hidden">
            <div class="rounded-xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-left text-gray-500 dark:bg-white/[0.03] dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 font-medium">Properti</th>
                                <th class="px-6 py-3 font-medium">Harga</th>
                                <th class="px-6 py-3 font-medium">Lokasi</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                                <th class="px-6 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse ($properties as $property)
                                @php
                                    $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                                        ?? $property->images->sortBy('sort_order')->first()?->path
                                        ?? 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=512';
                                    $pricePeriod = $property->price_period ? '/ ' . $property->price_period : '';
                                @endphp
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $cardImage }}" alt="{{ $property->title }}" class="h-12 w-12 rounded-lg object-cover">
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $property->title }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $property->bedrooms ?? 0 }} KT, {{ $property->bathrooms ?? 0 }} KM, {{ $property->land_area ?? $property->building_area ?? 0 }} m²</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-900 dark:text-white">
                                        Rp {{ $property->price ? number_format($property->price, 0, ',', '.') : '0' }} {{ $pricePeriod }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $property->city ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($property->is_published)
                                            <span class="rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600 dark:bg-green-500/10 dark:text-green-400">Published</span>
                                        @else
                                            <span class="rounded-full bg-gray-50 px-2.5 py-0.5 text-xs font-semibold text-gray-600 dark:bg-gray-500/10 dark:text-gray-400">Unpublished</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('agent.sewa.show', $property) }}" class="text-sm font-medium text-brand-600 hover:underline">Detail</a>
                                            <a href="{{ route('agent.sewa.edit', $property) }}" class="text-sm font-medium text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('agent.sewa.destroy', $property) }}" method="POST" onsubmit="return confirm('Hapus properti ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-500 hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada properti sewa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setView(view) {
            const cardView = document.getElementById('card-view');
            const tableView = document.getElementById('table-view');
            const btnCard = document.getElementById('btn-card-view');
            const btnTable = document.getElementById('btn-table-view');
            
            if (view === 'card') {
                cardView.classList.remove('hidden');
                tableView.classList.add('hidden');
                btnCard.classList.add('bg-blue-600', 'text-white');
                btnCard.classList.remove('text-gray-600', 'dark:text-gray-300');
                btnTable.classList.remove('bg-blue-600', 'text-white');
                btnTable.classList.add('text-gray-600', 'dark:text-gray-300');
            } else {
                cardView.classList.add('hidden');
                tableView.classList.remove('hidden');
                btnTable.classList.add('bg-blue-600', 'text-white');
                btnTable.classList.remove('text-gray-600', 'dark:text-gray-300');
                btnCard.classList.remove('bg-blue-600', 'text-white');
                btnCard.classList.add('text-gray-600', 'dark:text-gray-300');
            }
            
            localStorage.setItem('agentSewaViewPreference', view);
        }
        
        // Load saved preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('agentSewaViewPreference') || 'card';
            setView(savedView);
        });
    </script>
@endsection
