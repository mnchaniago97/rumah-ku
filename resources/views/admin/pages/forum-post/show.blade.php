@extends('admin.layouts.app')

@section('title', 'Detail Post Forum')

@section('content')
    <div class="w-full space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Post Forum</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Informasi lengkap posting dan komentarnya</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.forum-posts.index') }}"
                    class="rounded-lg border border-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <a href="{{ route('admin.forum-posts.edit', $post->id) }}"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-12">
                <div class="md:col-span-3">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Kategori</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ ucwords(str_replace('_', ' ', $post->category)) }}</p>
                </div>
                <div class="md:col-span-5">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Author</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $post->user?->name ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Komentar</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ (int) $post->comments_count }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Tanggal</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $post->created_at?->format('d M Y H:i') }}</p>
                </div>
                <div class="md:col-span-12">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Judul</p>
                    <p class="mt-1 text-base font-bold text-gray-900 dark:text-white">{{ $post->title }}</p>
                </div>
                <div class="md:col-span-12">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Isi</p>
                    <div class="prose mt-2 max-w-none text-gray-800 dark:text-gray-100">
                        {!! nl2br(e($post->body ?? '')) !!}
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-3 border-t border-gray-200 pt-6 dark:border-gray-800">
                <form action="{{ route('admin.forum-posts.destroy', $post->id) }}" method="POST"
                    onsubmit="return confirm('Hapus posting ini beserta semua komentarnya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Hapus Post
                    </button>
                </form>
                <a href="{{ route('admin.forum-comments.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-800">
                    Kelola Semua Komentar
                </a>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Komentar</h2>
                <span class="text-sm text-gray-600 dark:text-gray-300">{{ (int) $post->comments_count }} komentar</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800/40">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">User</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">Komentar</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($post->comments as $i => $comment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-white">{{ $comment->user?->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <p class="max-w-[680px] whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-100">{{ $comment->body }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $comment->created_at?->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.forum-comments.show', $comment->id) }}"
                                            class="inline-flex items-center justify-center rounded-lg p-2 text-green-700 hover:bg-green-50 dark:text-green-400 dark:hover:bg-gray-800"
                                            title="Detail komentar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.forum-comments.edit', $comment->id) }}"
                                            class="inline-flex items-center justify-center rounded-lg p-2 text-blue-700 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-gray-800"
                                            title="Edit komentar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.forum-comments.destroy', $comment->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus komentar ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center rounded-lg p-2 text-red-700 hover:bg-red-50 dark:text-red-400 dark:hover:bg-gray-800"
                                                title="Hapus komentar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-gray-500 dark:text-gray-300">
                                    Belum ada komentar pada posting ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

