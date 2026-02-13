@php
    $testimonial = $testimonial ?? null;
    $name = $testimonial?->name ?? 'John Doe';
    $role = $testimonial?->role ?? 'Pembeli Rumah';
    $content = $testimonial?->content ?? 'Pengalaman yang sangat baik! Tim Rumah Ku membantu saya menemukan rumah impian dalam waktu singkat. Sangat profesional dan terpercaya.';
    $rating = (int) ($testimonial?->rating ?? 5);
    $initials = collect(preg_split('/\s+/', trim($name)))->filter()->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode('');
@endphp

<div class="bg-white p-4 rounded-xl shadow">
    <div class="flex items-center gap-1 text-yellow-500 mb-2">
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star text-xs {{ $i <= $rating ? '' : 'opacity-30' }}"></i>
        @endfor
    </div>
    <p class="text-sm text-gray-600 line-clamp-3">
        "{{ $content }}"
    </p>
    <div class="mt-3 flex items-center gap-2">
        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-semibold overflow-hidden">
            @if($testimonial?->photo)
                <img src="{{ Storage::url($testimonial->photo) }}" alt="{{ $name }}" class="h-full w-full object-cover">
            @else
                {{ $initials ?: 'RK' }}
            @endif
        </div>
        <div>
            <p class="text-xs font-medium text-gray-900">{{ $name }}</p>
            <p class="text-xs text-gray-500">{{ $role }}</p>
        </div>
    </div>
</div>
