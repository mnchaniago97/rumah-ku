@extends('admin.layouts.app')

@section('title', 'Detail Banner')

@section('content')
    <div class="w-full">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Banner</h1>
                <p class="text-gray-600">Informasi lengkap banner</p>
            </div>
            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="w-full bg-white rounded-lg shadow p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}" class="w-full rounded-lg">
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Judul</label>
                        <p class="text-gray-800 font-medium">{{ $banner->title ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Link</label>
                        <p class="text-gray-800">
                            @if($banner->link)
                                <a href="{{ $banner->link }}" target="_blank" class="text-blue-600 hover:underline">{{ $banner->link }}</a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Posisi</label>
                        <p class="text-gray-800 capitalize">{{ $banner->position }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <span class="px-2 py-1 text-xs rounded-full {{ $banner->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $banner->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Urutan</label>
                        <p class="text-gray-800">{{ $banner->sort_order }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Berakhir</label>
                        <p class="text-gray-800">{{ $banner->end_date ? \Carbon\Carbon::parse($banner->end_date)->format('d M Y') : 'Tidak terbatas' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Dibuat</label>
                        <p class="text-gray-800">{{ $banner->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Diperbarui</label>
                        <p class="text-gray-800">{{ $banner->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-4 pt-6 border-t">
                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
