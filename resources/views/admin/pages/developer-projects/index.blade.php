@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Manajemen Proyek Developer</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola semua proyek developer di platform.</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
        <form method="GET" class="grid gap-4 md:grid-cols-4">
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, kota, provinsi..."
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Developer</label>
                <select name="developer_id" class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                    <option value="">Semua Developer</option>
                    @foreach($developers as $dev)
                        <option value="{{ $dev->id }}" @selected(request('developer_id') == $dev->id)>{{ $dev->company_name ?? $dev->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Status</label>
                <select name="status" class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="active" @selected(request('status') === 'active')>Aktif</option>
                    <option value="completed" @selected(request('status') === 'completed')>Selesai</option>
                    <option value="on-hold" @selected(request('status') === 'on-hold')>Ditunda</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Dibatalkan</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Publikasi</label>
                <select name="is_published" class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                    <option value="">Semua</option>
                    <option value="yes" @selected(request('is_published') === 'yes')>Dipublikasi</option>
                    <option value="no" @selected(request('is_published') === 'no')>Draft</option>
                </select>
            </div>
            <div class="md:col-span-4 flex gap-2">
                <button type="submit" class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                    <i class="fa fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.developer-projects.index') }}" class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Projects Table --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300">Proyek</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300">Developer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300">Lokasi</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300">Unit</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300">Publikasi</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center">
                                        @if(!empty($project->images) && isset($project->images[0]))
                                            <img src="{{ $project->images[0] }}" alt="{{ $project->name }}" class="h-full w-full object-cover">
                                        @elseif($project->logo)
                                            <img src="{{ $project->logo }}" alt="{{ $project->name }}" class="h-full w-full object-cover">
                                        @else
                                            <i class="fa fa-building text-gray-300"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-white">{{ $project->name }}</p>
                                        @if($project->price_start)
                                            <p class="text-xs text-gray-500">Rp {{ number_format($project->price_start, 0, ',', '.') }}
                                                @if($project->price_end)
                                                    - Rp {{ number_format($project->price_end, 0, ',', '.') }}
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($project->user)
                                    <p class="text-sm text-gray-800 dark:text-white">{{ $project->user->company_name ?? $project->user->name }}</p>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-800 dark:text-white">{{ $project->city ?? '-' }}</p>
                                <p class="text-xs text-gray-500">{{ $project->province ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm text-gray-800 dark:text-white">{{ $project->properties_count }}</span>
                                @if($project->total_units)
                                    <span class="text-xs text-gray-500">/ {{ $project->total_units }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block rounded-full px-2 py-0.5 text-xs font-medium {{ match($project->status) {
                                    'active' => 'bg-green-50 text-green-600',
                                    'completed' => 'bg-blue-50 text-blue-600',
                                    'on-hold' => 'bg-yellow-50 text-yellow-600',
                                    'cancelled' => 'bg-red-50 text-red-600',
                                    default => 'bg-gray-50 text-gray-600'
                                } }}">
                                    {{ ucfirst(str_replace('-', ' ', $project->status ?? 'active')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($project->is_published)
                                    <span class="inline-block rounded-full bg-green-50 px-2 py-0.5 text-xs font-medium text-green-600">Published</span>
                                @else
                                    <span class="inline-block rounded-full bg-gray-50 px-2 py-0.5 text-xs font-medium text-gray-600">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.developer-projects.show', $project) }}" class="text-brand-500 hover:text-brand-600" title="Lihat">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.developer-projects.edit', $project) }}" class="text-blue-500 hover:text-blue-600" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.developer-projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fa fa-building text-4xl text-gray-300 mb-2"></i>
                                <p>Tidak ada proyek ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($projects->hasPages())
            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
