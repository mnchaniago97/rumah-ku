@extends('admin.layouts.app')

@section('title', 'Edit Komentar Forum')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Komentar</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Ubah isi komentar</p>
            </div>
            <a href="{{ route('admin.forum-comments.show', $comment->id) }}"
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-800">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <form action="{{ route('admin.forum-comments.update', $comment->id) }}" method="POST"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                <div class="md:col-span-12">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Post</label>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->post?->title ?? '-' }}</p>
                </div>
                <div class="md:col-span-12">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">User</label>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->user?->name ?? '-' }}</p>
                </div>
                <div class="md:col-span-12">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Komentar</label>
                    <textarea name="body" rows="6" required
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('body', $comment->body) }}</textarea>
                    @error('body')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.forum-comments.show', $comment->id) }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>
@endsection

