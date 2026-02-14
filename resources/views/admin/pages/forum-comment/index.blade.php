@extends('admin.layouts.app')

@section('title', 'Kelola Komentar Forum')

@section('content')
    <div class="w-full space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Kelola Komentar Forum</h1>
                <p class="text-sm text-gray-600 dark:text-gray-300">Moderasi komentar dari seluruh posting</p>
            </div>
            <a href="{{ route('admin.forum-posts.index') }}"
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-800">
                Kelola Post
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="rounded-xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="grid grid-cols-1 gap-3 md:grid-cols-12">
                <div class="md:col-span-10">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Cari komentar</label>
                    <input name="q" value="{{ request('q') }}" placeholder="Isi komentar"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div class="md:col-span-2 flex items-end gap-2">
                    <button type="submit"
                        class="inline-flex h-11 w-full items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                        Filter
                    </button>
                    <a href="{{ route('admin.forum-comments.index') }}"
                        class="inline-flex h-11 items-center justify-center rounded-lg border border-gray-200 px-4 text-sm text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-800">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-gray-800/40">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">Post</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">User</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">Komentar</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($comments as $index => $comment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $index + $comments->firstItem() }}</td>
                                <td class="px-4 py-3">
                                    <a class="text-sm font-semibold text-gray-900 hover:underline dark:text-white"
                                        href="{{ route('admin.forum-posts.show', $comment->post?->id) }}">
                                        {{ $comment->post?->title ?? '-' }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $comment->user?->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <p class="max-w-[620px] truncate text-sm text-gray-800 dark:text-gray-100">{{ $comment->body }}</p>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $comment->created_at?->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.forum-comments.show', $comment->id) }}"
                                            class="inline-flex items-center justify-center rounded-lg p-2 text-green-700 hover:bg-green-50 dark:text-green-400 dark:hover:bg-gray-800"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.forum-comments.edit', $comment->id) }}"
                                            class="inline-flex items-center justify-center rounded-lg p-2 text-blue-700 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-gray-800"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.forum-comments.destroy', $comment->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus komentar ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center rounded-lg p-2 text-red-700 hover:bg-red-50 dark:text-red-400 dark:hover:bg-gray-800"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500 dark:text-gray-300">
                                    Belum ada komentar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($comments->hasPages())
                <div class="border-t border-gray-200 px-4 py-3 dark:border-gray-800">
                    {{ $comments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

