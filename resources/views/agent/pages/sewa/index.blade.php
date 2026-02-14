@extends('agent.layouts.app')

@section('content')
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Properti Sewa</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola listing properti sewa Anda.</p>
      </div>
      <a href="{{ route('agent.sewa.create') }}"
        class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
        <i class="fa fa-plus"></i>
        Tambah
      </a>
    </div>

    @if (session('success'))
      <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800 dark:border-green-900/40 dark:bg-green-900/20 dark:text-green-200">
        {{ session('success') }}
      </div>
    @endif

    <div class="rounded-xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50 text-left text-gray-500 dark:bg-white/[0.03] dark:text-gray-400">
            <tr>
              <th class="px-6 py-3 font-medium">Judul</th>
              <th class="px-6 py-3 font-medium">Kota</th>
              <th class="px-6 py-3 font-medium">Harga</th>
              <th class="px-6 py-3 font-medium">Status</th>
              <th class="px-6 py-3 font-medium text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @forelse(($properties ?? collect()) as $property)
              <tr>
                <td class="px-6 py-4 text-gray-900 dark:text-white">
                  <div class="font-semibold">{{ $property->title }}</div>
                  <div class="text-xs text-gray-500 dark:text-gray-400">{{ $property->slug }}</div>
                </td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $property->city ?? '-' }}</td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                  {{ $property->price ? ('Rp ' . number_format((float)$property->price, 0, ',', '.')) : '-' }}
                  @if(filled($property->price_period))
                    <span class="text-xs text-gray-500">/ {{ $property->price_period }}</span>
                  @endif
                </td>
                <td class="px-6 py-4">
                  <div class="flex flex-wrap items-center gap-2">
                    @if($property->is_published)
                      <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-500/10 dark:text-blue-300">Published</span>
                    @else
                      <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-700 dark:bg-white/[0.06] dark:text-gray-300">Draft</span>
                    @endif

                    @if($property->is_approved)
                      <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Approved</span>
                    @else
                      <span class="rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-semibold text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-300">Pending</span>
                    @endif
                  </div>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="inline-flex items-center gap-3">
                    <a href="{{ route('agent.sewa.show', $property) }}" class="text-sm font-medium text-gray-600 hover:underline dark:text-gray-300">Detail</a>
                    <a href="{{ route('agent.sewa.edit', $property) }}" class="text-sm font-medium text-green-600 hover:underline">Edit</a>
                    <form action="{{ route('agent.sewa.destroy', $property) }}" method="POST" onsubmit="return confirm('Hapus properti sewa ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-sm font-medium text-red-500 hover:underline">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                  Belum ada properti sewa.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

