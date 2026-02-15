@extends('admin.layouts.app')

@section('title', 'Kelola Banner')

@section('content')
    <div class="w-full">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Banner</h1>
            <a href="{{ route('admin.banners.create') }}" class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Banner
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tab Navigation --}}
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8" aria-label="Tabs">
                    @php
                        $locations = [
                            'hero' => 'Hero Banner (Atas)',
                            'ads_1' => 'Banner Iklan 1',
                            'ads_2' => 'Banner Iklan 2',
                            'ads_3' => 'Banner Iklan 3',
                            'bottom' => 'Banner Bawah',
                            'property_detail_sidebar' => 'Iklan Detail Properti (Sidebar)',
                        ];
                        $currentLocation = request()->get('location', 'hero');
                    @endphp
                    @foreach($locations as $loc => $label)
                        <a href="{{ route('admin.banners.index', ['location' => $loc]) }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm transition {{ $currentLocation === $loc ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- Banner List by Location --}}
        @php
            $currentBanners = $banners->filter(function($banner) use ($currentLocation) {
                return $banner->location === $currentLocation;
            });
        @endphp

        <div class="w-full bg-white rounded-lg shadow overflow-hidden">
            <div class="px-4 py-3 border-b bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-700">
                    @switch($currentLocation)
                        @case('hero')
                            Hero Banner (Awal halaman, di bawah navbar)
                            @break
                        @case('ads_1')
                            Banner Iklan 1 (Setelah rekomendasi)
                            @break
                        @case('ads_2')
                            Banner Iklan 2 (Setelah properti pilihan)
                            @break
                        @case('ads_3')
                            Banner Iklan 3 (Setelah properti populer)
                            @break
                        @case('bottom')
                            Banner Bawah (Akhir halaman)
                            @break
                        @case('property_detail_sidebar')
                            Iklan Detail Properti (Sidebar di halaman detail)
                            @break
                    @endswitch
                </h3>
            </div>

            @if($currentBanners->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    @foreach($currentBanners as $banner)
                        <div class="border rounded-lg overflow-hidden hover:shadow-md transition">
                            <div class="aspect-[3/1] bg-gray-100">
                                <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-3">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-800 truncate">{{ $banner->title ?? '-' }}</h4>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $banner->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $banner->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                    <span><i class="fas fa-signal mr-1"></i>Urutan: {{ $banner->sort_order }}</span>
                                    @if($banner->link)
                                        <span class="text-blue-600"><i class="fas fa-link mr-1"></i>Ada Link</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.banners.edit', $banner->id) }}" class="flex-1 py-2 text-center text-sm bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <a href="{{ route('admin.banners.show', $banner->id) }}" class="flex-1 py-2 text-center text-sm bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition">
                                        <i class="fas fa-eye mr-1"></i>Lihat
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="py-2 px-3 text-sm bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <i class="fas fa-image text-4xl mb-3 text-gray-300"></i>
                    <p class="text-gray-500 mb-4">Belum ada banner untuk lokasi ini.</p>
                    <a href="{{ route('admin.banners.create', ['location' => $currentLocation]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i>Tambah Banner {{ $locations[$currentLocation] }}
                    </a>
                </div>
            @endif
        </div>

        {{-- All Banners Table --}}
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Semua Banner</h3>
            <div class="w-full bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">No</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Gambar</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Judul</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Lokasi</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Urutan</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($banners as $index => $banner)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $index + $banners->firstItem() }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}" class="w-20 h-12 object-cover rounded">
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $banner->title ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">
                                        @switch($banner->location)
                                            @case('hero')
                                                Hero Banner
                                                @break
                                            @case('ads_1')
                                                Banner Iklan 1
                                                @break
                                            @case('ads_2')
                                                Banner Iklan 2
                                                @break
                                            @case('ads_3')
                                                Banner Iklan 3
                                                @break
                                            @case('bottom')
                                                Banner Bawah
                                                @break
                                            @case('property_detail_sidebar')
                                                Iklan Detail Properti (Sidebar)
                                                @break
                                            @default
                                                {{ $banner->location }}
                                        @endswitch
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $banner->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $banner->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $banner->sort_order }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.banners.show', $banner->id) }}" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-image text-4xl mb-3 text-gray-300"></i>
                                        <p>Belum ada banner. Tambahkan banner pertama Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($banners->hasPages())
                    <div class="px-4 py-3 border-t">
                        {{ $banners->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
