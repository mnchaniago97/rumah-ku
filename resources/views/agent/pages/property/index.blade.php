@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Properti Dijual</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola listing properti dijual.</p>
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
                <a href="{{ route('agent.properties.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    + Tambah Properti
                </a>
            </div>
        </div>

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
                    
                    $bedrooms = $property->bedrooms ?? 0;
                    $bathrooms = $property->bathrooms ?? 0;
                    $area = $property->land_area ?? $property->building_area ?? 0;
                @endphp
                <div class="relative mx-auto w-full">
                    <a href="{{ route('agent.properties.show', $property) }}" class="relative inline-block w-full transform transition-transform duration-300 ease-in-out hover:-translate-y-2">
                        <div class="rounded-lg bg-white p-4 shadow">
                            <div class="relative flex h-52 justify-center overflow-hidden rounded-lg">
                                <div class="w-full transform transition-transform duration-500 ease-in-out hover:scale-110">
                                    <div class="absolute inset-0 bg-black bg-opacity-80">
                                        <img src="{{ $cardImage }}" alt="{{ $property->title }}" />
                                    </div>
                                </div>

                                <div class="absolute bottom-0 left-5 mb-3 flex">
                                    <p class="flex items-center text-xs font-semibold text-white shadow-sm">
                                        <i class="fa fa-camera mr-2 text-base text-white"></i>
                                        {{ $property->images->count() }}
                                    </p>
                                </div>

                                <span class="absolute top-0 right-2 z-10 mt-3 ml-3 inline-flex select-none rounded-sm bg-[#1f93ff] px-2 py-1 text-xs font-semibold text-white">
                                    {{ $property->type ?? 'Residential' }}
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
                                <h2 class="line-clamp-1 text-base font-semibold text-gray-800" title="{{ $property->title }}">
                                    {{ $property->title }}
                                </h2>
                                @if(($property->listingCategories ?? collect())->count() > 0)
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        @foreach($property->listingCategories->sortBy('sort_order')->take(3) as $cat)
                                            <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-700">{{ $cat->name }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <p class="mt-2 inline-flex items-end gap-1 whitespace-nowrap font-semibold leading-tight text-gray-900">
                                    <span class="text-[10px] uppercase text-gray-600">Rp</span>
                                    <span class="text-lg">{{ $property->price ? number_format($property->price, 0, ',', '.') : '0' }}</span>
                                </p>
                            </div>
                            <div class="mt-4">
                                <p class="line-clamp-1 mt-2 text-sm text-gray-700">{{ $property->address ?? 'Alamat belum diisi' }}</p>
                            </div>
                            <div class="justify-center">
                                <div class="mt-4 flex flex-wrap gap-3 overflow-hidden rounded-lg px-1 py-1">
                                    <p class="flex items-center text-sm font-semibold text-gray-800">
                                        <i class="fa fa-bed mr-2 text-blue-900"></i>
                                        {{ $bedrooms }}
                                    </p>

                                    <p class="flex items-center text-sm font-semibold text-gray-800">
                                        <i class="fa fa-bath mr-2 text-blue-900"></i>
                                        {{ $bathrooms }}
                                    </p>
                                    <p class="flex items-center text-sm font-semibold text-gray-800">
                                        <i class="fa fa-home mr-2 text-blue-900"></i>
                                        {{ $area }} m<sup>2</sup>
                                    </p>
                                </div>
                                <div class="mt-2 flex flex-wrap gap-3 overflow-hidden rounded-lg px-1 py-1">
                                    @if($property->electricity)
                                    <p class="flex items-center text-sm font-semibold text-gray-800">
                                        <i class="fa fa-bolt mr-2 text-yellow-500"></i>
                                        {{ $property->electricity }} Watt
                                    </p>
                                    @endif
                                    @if($property->water_source)
                                    <p class="flex items-center text-sm font-semibold text-gray-800">
                                        <i class="fa fa-tint mr-2 text-blue-500"></i>
                                        {{ $property->water_source }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-8 grid grid-cols-2">
                                 <div class="flex items-center">
                                     @if($property->user && $property->user->role === 'admin')
                                         <div class="relative">
                                             <div class="h-6 w-6 rounded-full bg-brand-500 flex items-center justify-center overflow-hidden md:h-8 md:w-8">
                                                 @if($property->user->avatar)
                                                     <img src="{{ $property->user->avatar }}" alt="{{ $property->user->name }}" class="h-full w-full object-cover">
                                                 @else
                                                     <i class="fa fa-building text-white text-xs"></i>
                                                 @endif
                                             </div>
                                         </div>
                                         <div class="ml-2">
                                             <p class="line-clamp-1 text-sm font-semibold text-brand-600">{{ $property->user->name ?? 'Official Rumah IO' }}</p>
                                             <p class="text-[10px] text-brand-500">Official Rumah IO</p>
                                         </div>
                                     @else
                                         <div class="relative">
                                             <div class="h-6 w-6 rounded-full bg-gray-200 md:h-8 md:w-8">
                                                 @if($property->user && $property->user->avatar)
                                                     <img src="{{ $property->user->avatar }}" alt="{{ $property->user->name }}" class="h-6 w-6 rounded-full md:h-8 md:w-8 object-cover">
                                                 @endif
                                             </div>
                                             <span class="bg-primary-red absolute top-0 right-0 inline-block h-3 w-3 rounded-full"></span>
                                         </div>
                                         <p class="line-clamp-1 ml-2 text-sm text-gray-800">{{ $property->user?->name ?? 'Agent' }}</p>
                                     @endif
                                 </div>
                                 <div class="flex items-center justify-end">
                                     <form action="{{ route('agent.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Hapus properti ini?')">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-600">
                                             <i class="fa fa-trash"></i>
                                             Hapus
                                         </button>
                                     </form>
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
                                <th class="px-6 py-3 font-medium">Tipe</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                                <th class="px-6 py-3 font-medium">Pemilik</th>
                                <th class="px-6 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse ($properties as $property)
                                @php
                                    $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                                        ?? $property->images->sortBy('sort_order')->first()?->path
                                        ?? 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=512';
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
                                        Rp {{ $property->price ? number_format($property->price, 0, ',', '.') : '0' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $property->city ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $property->type ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($property->is_published)
                                            <span class="rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600 dark:bg-green-500/10 dark:text-green-400">Published</span>
                                        @else
                                            <span class="rounded-full bg-gray-50 px-2.5 py-0.5 text-xs font-semibold text-gray-600 dark:bg-gray-500/10 dark:text-gray-400">Unpublished</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($property->user && $property->user->role === 'admin')
                                            <div class="flex items-center gap-2">
                                                <div class="h-6 w-6 rounded-full bg-brand-500 flex items-center justify-center overflow-hidden">
                                                    @if($property->user->avatar)
                                                        <img src="{{ $property->user->avatar }}" alt="{{ $property->user->name }}" class="h-full w-full object-cover">
                                                    @else
                                                        <i class="fa fa-building text-white text-xs"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-brand-600">{{ $property->user->name ?? 'Official' }}</p>
                                                    <p class="text-[10px] text-brand-500">Official Rumah IO</p>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-800 dark:text-gray-200">{{ $property->user?->name ?? 'Admin' }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="inline-flex items-center gap-3">
                                            <a href="{{ route('agent.properties.show', $property) }}" class="text-sm font-medium text-brand-600 hover:underline">Detail</a>
                                            <form action="{{ route('agent.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Hapus properti ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-500 hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data property.
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
                btnCard.classList.add('bg-brand-500', 'text-white');
                btnCard.classList.remove('text-gray-600', 'dark:text-gray-300');
                btnTable.classList.remove('bg-brand-500', 'text-white');
                btnTable.classList.add('text-gray-600', 'dark:text-gray-300');
            } else {
                cardView.classList.add('hidden');
                tableView.classList.remove('hidden');
                btnTable.classList.add('bg-brand-500', 'text-white');
                btnTable.classList.remove('text-gray-600', 'dark:text-gray-300');
                btnCard.classList.remove('bg-brand-500', 'text-white');
                btnCard.classList.add('text-gray-600', 'dark:text-gray-300');
            }
            
            localStorage.setItem('agentPropertyViewPreference', view);
        }
        
        // Load saved preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('agentPropertyViewPreference') || 'card';
            setView(savedView);
        });
    </script>
@endsection
