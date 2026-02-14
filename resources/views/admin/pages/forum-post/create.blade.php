@extends('admin.layouts.app')

@section('title', 'Tambah Post Forum')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Tambah Post Forum</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Posting baru akan tampil di halaman frontend forum</p>
            </div>
            <a href="{{ route('admin.forum-posts.index') }}"
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-800">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <form action="{{ route('admin.forum-posts.store') }}" method="POST"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            @csrf

            <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                <div class="md:col-span-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                    <select name="category" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" @selected(old('category', 'beli_rumah') === $cat)>
                                {{ ucwords(str_replace('_', ' ', $cat)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-8">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                    <input name="title" value="{{ old('title') }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-12">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Isi</label>
                    <textarea name="body" rows="8"
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white"
                        placeholder="Tulis isi posting...">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan
                </button>
                <a href="{{ route('admin.forum-posts.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>
@endsection

