@extends('frontend.layouts.app')

@section('content')
    @php
        $image = $article->image ? Storage::url($article->image) : null;
        $date = $article->published_at ?? $article->created_at;
    @endphp

    <div class="bg-gray-50">
        <div class="max-w-[1200px] mx-auto px-4 py-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <article class="rounded-2xl bg-white shadow-sm overflow-hidden">
                        @if($image)
                            <div class="aspect-[16/9] bg-gray-200">
                                <img src="{{ $image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div class="p-6">
                            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                <span class="rounded-full bg-blue-100 px-2 py-1 text-blue-600">{{ $article->category ?? 'Info' }}</span>
                                <span><i class="fa fa-calendar mr-1"></i> {{ $date->format('d M Y') }}</span>
                            </div>

                            <h1 class="mt-3 text-2xl font-bold text-gray-900">{{ $article->title }}</h1>

                            @if($article->excerpt)
                                <p class="mt-3 text-gray-600">{{ $article->excerpt }}</p>
                            @endif

                            <div class="prose prose-sm mt-6 max-w-none text-gray-700">
                                {!! nl2br(e($article->content ?? '')) !!}
                            </div>
                        </div>
                    </article>
                </div>

                <aside class="lg:col-span-4">
                    <div class="sticky top-6 space-y-4">
                        <div class="rounded-2xl bg-white p-5 shadow-sm">
                            <p class="text-sm font-semibold text-gray-900">Artikel Terbaru</p>
                            <div class="mt-4 space-y-3">
                                @forelse($latestArticles as $item)
                                    <a href="{{ route('articles.show', $item->slug) }}" class="flex items-start gap-3 group">
                                        <div class="h-14 w-20 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                            <img
                                                src="{{ $item->image ? Storage::url($item->image) : 'https://source.unsplash.com/400x300/?house&sig=' . $item->id }}"
                                                alt="{{ $item->title }}" class="h-full w-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 line-clamp-2 group-hover:text-blue-600">{{ $item->title }}</p>
                                            <p class="mt-1 text-xs text-gray-500">{{ ($item->published_at ?? $item->created_at)->format('d M Y') }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada artikel lain.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
@endsection

