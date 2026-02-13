@extends('admin.layouts.app')

@section('title', 'Kelola Testimoni')

@section('content')
    <div class="w-full">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Testimoni</h1>
            <a href="{{ route('admin.testimonials.create') }}"
                class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Testimoni
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="w-full bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($testimonials as $index => $testimonial)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $index + $testimonials->firstItem() }}</td>
                                <td class="px-4 py-3">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden">
                                        @if ($testimonial->photo)
                                            <img src="{{ Storage::url($testimonial->photo) }}" alt="{{ $testimonial->name }}"
                                                class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium text-gray-800">{{ $testimonial->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $testimonial->role ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $testimonial->rating }}/5
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $testimonial->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $testimonial->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $testimonial->sort_order }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.testimonials.show', $testimonial->id) }}"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                    <i class="fas fa-comment-dots text-4xl mb-3 text-gray-300"></i>
                                    <p>Belum ada testimoni.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($testimonials->hasPages())
                <div class="px-4 py-3 border-t">
                    {{ $testimonials->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

