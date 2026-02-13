@extends('admin.layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
    <div class="w-full">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Artikel</h1>
            <a href="{{ route('admin.articles.create') }}"
                class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Artikel
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
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Publish</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($articles as $index => $article)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $index + $articles->firstItem() }}</td>
                                <td class="px-4 py-3">
                                    <div class="h-12 w-20 rounded bg-gray-100 overflow-hidden">
                                        @if ($article->image)
                                            <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}"
                                                class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-sm font-medium text-gray-800">{{ $article->title }}</p>
                                    <p class="text-xs text-gray-500">/{{ $article->slug }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $article->category ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $article->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $article->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.articles.edit', $article->id) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.articles.show', $article->id) }}"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                    <i class="fas fa-file-alt text-4xl mb-3 text-gray-300"></i>
                                    <p>Belum ada artikel.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($articles->hasPages())
                <div class="px-4 py-3 border-t">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

