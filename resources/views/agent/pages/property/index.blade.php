@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Property</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola listing property.</p>
            </div>
            <a href="{{ route('agent.properties.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                + Tambah Property
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($properties as $property)
                @php
                    $cardImage = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                        ?? $property->images->sortBy('sort_order')->first()?->path
                        ?? 'https://ui-avatars.com/api/?name=' . urlencode($property->title) . '&background=random&color=fff&size=512';
                @endphp
                <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="mb-5 overflow-hidden rounded-lg">
                        <img src="{{ $cardImage }}" alt="{{ $property->title }}"
                            class="h-48 w-full overflow-hidden rounded-lg object-cover">
                    </div>

                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                        <span class="rounded-full bg-gray-100 px-2 py-0.5 dark:bg-white/10">
                            {{ $property->category?->name ?? 'Tanpa Kategori' }}
                        </span>
                        @foreach(($property->listingCategories ?? collect())->sortBy('sort_order')->take(2) as $cat)
                            <span class="rounded-full bg-blue-50 px-2 py-0.5 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">
                                {{ $cat->name }}
                            </span>
                        @endforeach
                        @if ($property->is_published)
                            <span class="rounded-full bg-green-50 px-2 py-0.5 text-green-600 dark:bg-green-500/10 dark:text-green-400">Published</span>
                        @else
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 dark:bg-white/10">Draft</span>
                        @endif
                        @if (!$property->is_approved)
                            <span class="rounded-full bg-yellow-50 px-2 py-0.5 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-300">Pending Approval</span>
                        @endif
                    </div>

                    <h4 class="mt-3 mb-1 text-theme-xl font-medium text-gray-800 dark:text-white/90">
                        {{ $property->title }}
                    </h4>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $property->address ?? 'Alamat belum diisi' }}
                    </p>

                    <p class="mt-2 text-sm font-semibold text-brand-500">
                        {{ $property->price ? 'Rp ' . number_format($property->price, 0, ',', '.') : 'Harga belum diisi' }}
                    </p>

                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <a href="{{ route('agent.properties.show', $property) }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600">
                            Detail
                        </a>
                        <a href="{{ route('agent.properties.edit', $property) }}" class="text-sm font-medium text-gray-600 hover:underline dark:text-gray-300">Edit</a>
                        <form action="{{ route('agent.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Hapus property ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-red-500 hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-gray-200 bg-white p-6 text-center text-sm text-gray-500 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400">
                    Belum ada data property.
                </div>
            @endforelse
        </div>
    </div>
@endsection

