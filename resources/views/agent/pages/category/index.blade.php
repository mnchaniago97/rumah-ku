@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Category</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola kategori properti.</p>
            </div>
            <a href="{{ route('agent.categories.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                + Tambah Kategori
            </a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Daftar Kategori</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500 dark:bg-white/[0.03] dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3 font-medium">Nama</th>
                            <th class="px-6 py-3 font-medium">Slug</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $category->slug ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if ($category->is_active)
                                        <span class="rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600 dark:bg-green-500/10 dark:text-green-400">Aktif</span>
                                    @else
                                        <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-600 dark:bg-white/10 dark:text-gray-300">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <a href="{{ route('agent.categories.show', $category) }}" class="text-sm font-medium text-gray-600 hover:underline dark:text-gray-300">Detail</a>
                                        <a href="{{ route('agent.categories.edit', $category) }}" class="text-sm font-medium text-brand-500 hover:underline">Edit</a>
                                        <form action="{{ route('agent.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium text-red-500 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

