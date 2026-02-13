@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Category Detail</h1>
            <a href="{{ route('admin.categories.edit', $category) }}"
                class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">Edit</a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Nama</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Slug</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->slug ?? '-' }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Deskripsi</dt>
                    <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $category->description ?? '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
