@extends('admin.layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
    <div class="w-full">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Artikel</h1>
            <p class="text-gray-600">Tambahkan artikel/blog baru</p>
        </div>

        <div class="w-full bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Judul artikel"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slug (Opsional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" placeholder="otomatis dari judul"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori (Opsional)</label>
                        <input type="text" name="category" value="{{ old('category') }}" placeholder="Tips / Panduan"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('category')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt (Opsional)</label>
                        <input type="text" name="excerpt" value="{{ old('excerpt') }}" placeholder="Ringkasan singkat"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konten (Opsional)</label>
                        <textarea name="content" rows="10" placeholder="Isi artikel..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="is_published"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <option value="1" {{ old('is_published', '1') === '1' ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ old('is_published') === '0' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('is_published')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish (Opsional)</label>
                        <input type="date" name="published_at" value="{{ old('published_at') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar (Opsional)</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex gap-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.articles.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

