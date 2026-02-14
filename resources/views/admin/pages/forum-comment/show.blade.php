@extends('admin.layouts.app')

@section('title', 'Detail Komentar Forum')

@section('content')
    <div class="w-full space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Komentar</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Informasi lengkap komentar</p>
            </div>
            <a href="{{ route('admin.forum-comments.index') }}"
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-800">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                <div class="md:col-span-6">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Post</p>
                    <a href="{{ route('admin.forum-posts.show', $comment->post?->id) }}"
                        class="mt-1 inline-block text-sm font-semibold text-gray-900 hover:underline dark:text-white">
                        {{ $comment->post?->title ?? '-' }}
                    </a>
                </div>
                <div class="md:col-span-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">User</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->user?->name ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Tanggal</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->created_at?->format('d M Y H:i') }}</p>
                </div>
                <div class="md:col-span-12">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Komentar</p>
                    <p class="mt-2 whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-100">{{ $comment->body }}</p>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3 border-t border-gray-200 pt-6 dark:border-gray-800">
                <a href="{{ route('admin.forum-comments.edit', $comment->id) }}"
                    class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.forum-comments.destroy', $comment->id) }}" method="POST"
                    onsubmit="return confirm('Hapus komentar ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

