@extends('agent.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Proyek Developer" />

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Proyek Saya</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    @if($maxProjects === -1)
                        Paket Anda: Unlimited proyek aktif
                    @else
                        Paket Anda: {{ $activeProjects }}/{{ $maxProjects }} proyek aktif
                    @endif
                </p>
            </div>
            @if($canCreateProject)
                <a href="{{ route('agent.developer-projects.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                    <i class="fa fa-plus"></i>
                    Tambah Proyek
                </a>
            @else
                <span class="inline-flex items-center gap-2 rounded-lg bg-gray-300 px-4 py-2 text-sm font-semibold text-gray-600 cursor-not-allowed">
                    <i class="fa fa-plus"></i>
                    Batas Proyek Tercapai
                </span>
            @endif
        </div>

        @if($projects->count() > 0)
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($projects as $project)
                    <div class="rounded-xl border border-gray-200 bg-white overflow-hidden dark:border-gray-800 dark:bg-gray-900">
                        <div class="h-40 bg-gray-100 flex items-center justify-center">
                            @if($project->logo)
                                <img src="{{ $project->logo }}" alt="{{ $project->name }}" class="h-full w-full object-cover">
                            @else
                                <i class="fa fa-building text-gray-300 text-5xl"></i>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">{{ $project->name }}</h4>
                                @if($project->is_published)
                                    <span class="rounded-full bg-green-50 px-2 py-0.5 text-xs font-semibold text-green-600">Published</span>
                                @else
                                    <span class="rounded-full bg-gray-50 px-2 py-0.5 text-xs font-semibold text-gray-600">Draft</span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                <i class="fa fa-map-marker mr-1"></i>
                                {{ $project->city ?? '-' }}, {{ $project->province ?? '-' }}
                            </p>
                            <div class="mt-2 flex items-center gap-4 text-xs text-gray-500">
                                @if($project->price_start)
                                    <span>Rp {{ number_format($project->price_start, 0, ',', '.') }}</span>
                                    @if($project->price_end)
                                        <span>- Rp {{ number_format($project->price_end, 0, ',', '.') }}</span>
                                    @endif
                                @endif
                            </div>
                            <div class="mt-3 flex items-center gap-2">
                                <span class="text-xs {{ match($project->status) {
                                    'active' => 'bg-green-50 text-green-600',
                                    'completed' => 'bg-blue-50 text-blue-600',
                                    'on-hold' => 'bg-yellow-50 text-yellow-600',
                                    'cancelled' => 'bg-red-50 text-red-600',
                                    default => 'bg-gray-50 text-gray-600'
                                } }} rounded-full px-2 py-0.5 font-medium">
                                    {{ ucfirst(str_replace('-', ' ', $project->status ?? 'active')) }}
                                </span>
                                @if($project->total_units)
                                    <span class="text-xs text-gray-500">{{ $project->available_units ?? 0 }}/{{ $project->total_units }} unit</span>
                                @endif
                            </div>
                            <div class="mt-4 flex items-center gap-2">
                                <a href="{{ route('agent.developer-projects.show', $project) }}"
                                    class="flex-1 rounded-lg border border-gray-200 bg-white px-3 py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    Lihat
                                </a>
                                <a href="{{ route('agent.developer-projects.edit', $project) }}"
                                    class="flex-1 rounded-lg bg-brand-500 px-3 py-2 text-center text-sm font-medium text-white hover:bg-brand-600">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 p-12 text-center dark:border-gray-700 dark:bg-gray-800/50">
                <i class="fa fa-building mb-3 text-4xl text-gray-300"></i>
                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Belum ada proyek</h4>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai buat proyek pertama Anda untuk mengelola properti developer.</p>
                @if($canCreateProject)
                    <a href="{{ route('agent.developer-projects.create') }}"
                        class="mt-4 inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                        <i class="fa fa-plus"></i>
                        Tambah Proyek
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection