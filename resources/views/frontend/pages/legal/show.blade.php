@extends('frontend.layouts.app')

@section('content')
@php
    $content = $content ?? '';
    $active = $active ?? null;
    $pages = $pages ?? [];
@endphp

<div class="bg-gray-50">
    <div class="max-w-[1200px] mx-auto px-4 py-10">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $title ?? 'Halaman' }}</h1>
                <p class="mt-2 text-sm text-gray-600">Informasi penting terkait penggunaan platform.</p>
            </div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-12">
            <aside class="lg:col-span-3">
                <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="text-xs font-semibold uppercase tracking-wider text-gray-500">Dokumen</div>
                    <nav class="mt-3 space-y-1">
                        @foreach($pages as $key => $row)
                            @php
                                $isActive = $active === $key;
                                $href = url('/' . ($row['slug'] ?? ''));
                            @endphp
                            <a href="{{ $href }}"
                                class="flex items-center justify-between rounded-xl px-3 py-2 text-sm transition {{ $isActive ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span>{{ $row['label'] ?? $key }}</span>
                                <i class="fa fa-chevron-right text-xs {{ $isActive ? 'text-blue-600' : 'text-gray-400' }}"></i>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </aside>

            <main class="lg:col-span-9">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="prose prose-gray max-w-none">
                        {!! nl2br(e($content)) !!}
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection

