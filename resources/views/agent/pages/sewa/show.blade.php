@extends('agent.layouts.app')

@section('content')
  @php
    /** @var \App\Models\Property $property */
  @endphp

  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Detail Properti Sewa</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $property->title }}</p>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('agent.sewa.edit', $property) }}"
          class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
          <i class="fa fa-pen"></i>
          Edit
        </a>
        <a href="{{ route('agent.sewa.index') }}" class="text-sm font-semibold text-gray-700 hover:underline dark:text-gray-200">Kembali</a>
      </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
      <dl class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
          <dt class="text-xs text-gray-500 dark:text-gray-400">Judul</dt>
          <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $property->title }}</dd>
        </div>
        <div>
          <dt class="text-xs text-gray-500 dark:text-gray-400">Slug</dt>
          <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $property->slug ?? '-' }}</dd>
        </div>
        <div>
          <dt class="text-xs text-gray-500 dark:text-gray-400">Harga</dt>
          <dd class="text-sm text-gray-700 dark:text-gray-300">
            {{ $property->price ? ('Rp ' . number_format((float)$property->price, 0, ',', '.')) : '-' }}
            @if(filled($property->price_period))
              <span class="text-xs text-gray-500">/ {{ $property->price_period }}</span>
            @endif
          </dd>
        </div>
        <div>
          <dt class="text-xs text-gray-500 dark:text-gray-400">Kota</dt>
          <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $property->city ?? '-' }}</dd>
        </div>
        <div class="md:col-span-2">
          <dt class="text-xs text-gray-500 dark:text-gray-400">Alamat</dt>
          <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $property->address ?? '-' }}</dd>
        </div>
        <div class="md:col-span-2">
          <dt class="text-xs text-gray-500 dark:text-gray-400">Deskripsi</dt>
          <dd class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $property->description ?? '-' }}</dd>
        </div>
      </dl>

      @if(($property->images ?? collect())->count() > 0)
        <div class="mt-6">
          <div class="text-sm font-semibold text-gray-900 dark:text-white">Foto</div>
          <div class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
            @foreach($property->images as $image)
              @php
                $imgPath = (string) ($image->path ?? '');
                if ($imgPath !== '' && !str_starts_with($imgPath, 'http') && !str_starts_with($imgPath, '/')) {
                    $imgPath = '/storage/' . ltrim($imgPath, '/');
                }
              @endphp
              <img src="{{ $imgPath }}" alt="Foto properti" class="h-28 w-full rounded-lg border border-gray-200 object-cover dark:border-gray-800" loading="lazy">
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection

