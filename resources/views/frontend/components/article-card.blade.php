@php
    $article = $article ?? null;

    $title = $article?->title ?? 'Tips Membeli Rumah Pertama untuk Millennial';
    $category = $article?->category ?? 'Tips';
    $excerpt = $article?->excerpt ?? 'Panduan lengkap bagi millennial yang ingin memiliki rumah pertama mereka dengan budget yang terbatas...';
    $image = $article?->image ? Storage::url($article->image) : '/assets/admin/images/grid-image/image-02.png';
    $date = $article?->published_at ?? $article?->created_at ?? now();
    $href = $article?->slug ? route('articles.show', $article->slug) : '#';
@endphp

<a href="{{ $href }}" class="block bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition group">
    <div class="aspect-[16/9] bg-gray-200 relative">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
    </div>
    <div class="p-4">
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
            <span class="rounded-full bg-blue-100 px-2 py-1 text-blue-600">{{ $category }}</span>
            <span><i class="fa fa-calendar mr-1"></i> {{ $date->format('d M Y') }}</span>
        </div>
        <h4 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600">
            {{ $title }}
        </h4>
        <p class="text-xs text-gray-600 mt-2 line-clamp-2">
            {{ $excerpt }}
        </p>
        <span class="mt-3 inline-block text-sm font-medium text-blue-600 hover:text-blue-700">
            Baca Selengkapnya →
        </span>
    </div>
</a>

