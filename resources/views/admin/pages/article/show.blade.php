@extends('admin.layouts.app')

@section('title', 'Detail Artikel')

@section('content')
    <div class="w-full">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Artikel</h1>
                <p class="text-gray-600">Informasi lengkap artikel</p>
            </div>
            <a href="{{ route('admin.articles.index') }}"
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="w-full bg-white rounded-lg shadow p-6">
            @if ($article->image)
                <div class="mb-6">
                    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full rounded-lg">
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Judul</label>
                    <p class="text-gray-900 font-semibold">{{ $article->title }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Slug</label>
                    <p class="text-gray-700">/{{ $article->slug }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Kategori</label>
                    <p class="text-gray-700">{{ $article->category ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Status</label>
                    <span
                        class="px-2 py-1 text-xs rounded-full {{ $article->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $article->is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Published At</label>
                    <p class="text-gray-700">{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Excerpt</label>
                    <p class="text-gray-800">{{ $article->excerpt ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500">Konten</label>
                    <div class="prose max-w-none">
                        {!! nl2br(e($article->content ?? '')) !!}
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-4 pt-6 border-t">
                <a href="{{ route('admin.articles.edit', $article->id) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
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

