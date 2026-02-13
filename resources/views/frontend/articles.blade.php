@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Info Properti</h1>
                <p class="mt-2 text-gray-600">Tips, panduan, dan informasi menarik seputar properti</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($articles as $article)
                    <article class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                        <a href="{{ route('articles.show', $article->slug) }}" class="block">
                            <div class="aspect-video bg-gray-200">
                                <img
                                    src="{{ $article->image ? Storage::url($article->image) : 'https://source.unsplash.com/800x600/?house,property&sig=' . $article->id }}"
                                    alt="{{ $article->title }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                                    <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded">{{ $article->category ?? 'Info' }}</span>
                                    <span>{{ ($article->published_at ?? $article->created_at)->format('d M Y') }}</span>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $article->title }}
                                </h2>
                                @if($article->excerpt)
                                    <p class="text-sm text-gray-600 line-clamp-3 mb-4">
                                        {{ $article->excerpt }}
                                    </p>
                                @endif
                                <span class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                    Baca Selengkapnya →
                                </span>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="col-span-full rounded-xl border border-dashed border-gray-200 bg-white p-12 text-center">
                        <i class="fa fa-newspaper text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada artikel.</p>
                    </div>
                @endforelse
            </div>

            @if(method_exists($articles, 'links'))
                <div class="mt-10">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

