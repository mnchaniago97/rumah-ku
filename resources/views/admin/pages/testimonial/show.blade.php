@extends('admin.layouts.app')

@section('title', 'Detail Testimoni')

@section('content')
    <div class="w-full">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Testimoni</h1>
                <p class="text-gray-600">Informasi lengkap testimoni</p>
            </div>
            <a href="{{ route('admin.testimonials.index') }}"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="w-full bg-white rounded-lg shadow p-6">
            <div class="flex items-start gap-6">
                <div class="h-20 w-20 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                    @if ($testimonial->photo)
                        <img src="{{ Storage::url($testimonial->photo) }}" alt="{{ $testimonial->name }}"
                            class="h-full w-full object-cover">
                    @endif
                </div>
                <div class="flex-1 space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama</label>
                        <p class="text-gray-900 font-semibold">{{ $testimonial->name }}</p>
                        <p class="text-sm text-gray-600">{{ $testimonial->role ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Rating</label>
                        <p class="text-gray-900">{{ $testimonial->rating }}/5</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <span
                            class="px-2 py-1 text-xs rounded-full {{ $testimonial->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $testimonial->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Konten</label>
                        <p class="mt-1 text-gray-800 whitespace-pre-line">{{ $testimonial->content }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-4 pt-6 border-t">
                <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
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

