@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Property Detail</h1>
            <a href="{{ route('agent.properties.edit', $property) }}"
                class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">Edit</a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Judul</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->title }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Harga</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $property->price ? 'Rp ' . number_format($property->price, 0, ',', '.') : '-' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Kota</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->city ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Provinsi</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->province ?? '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Alamat</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $property->address ?? '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Deskripsi</dt>
                    <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $property->description ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection

