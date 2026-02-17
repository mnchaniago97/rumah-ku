@extends('agent.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Laporan & Analitik" />

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        <!-- Total Properties -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Properti</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $totalProperties }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-900/20">
                    <i class="fa fa-home text-blue-500 text-xl"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">
                <span class="text-green-500"><i class="fa fa-arrow-up"></i> {{ $publishedProperties }}</span> aktif
            </p>
        </div>

        <!-- Total Projects -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Proyek</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $totalProjects }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 dark:bg-purple-900/20">
                    <i class="fa fa-building text-purple-500 text-xl"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">
                <span class="text-green-500"><i class="fa fa-check"></i> {{ $activeProjects }}</span> proyek aktif
            </p>
        </div>

        <!-- Total Views -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Views</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ number_format($totalViews) }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 dark:bg-green-900/20">
                    <i class="fa fa-eye text-green-500 text-xl"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">
                <span class="text-green-500"><i class="fa fa-arrow-up"></i> {{ $viewsThisMonth }}</span> bulan ini
            </p>
        </div>

        <!-- Total Inquiries -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Inquiries</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white/90">{{ $totalInquiries }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-50 dark:bg-yellow-900/20">
                    <i class="fa fa-envelope text-yellow-500 text-xl"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-gray-500">
                <span class="text-green-500"><i class="fa fa-arrow-up"></i> {{ $inquiriesThisMonth }}</span> bulan ini
            </p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
        <!-- Views Chart -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Statistik Views (6 Bulan Terakhir)</h4>
            <div class="h-64">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>

        <!-- Inquiries Chart -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Statistik Inquiries (6 Bulan Terakhir)</h4>
            <div class="h-64">
                <canvas id="inquiriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Property by Status -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <!-- Properties by Status -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Properti per Status</h4>
            <div class="h-64">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Properties by Category -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Properti per Kategori</h4>
            <div class="h-64">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Top Projects -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Proyek Terpopuler</h4>
            <div class="space-y-4">
                @if($topProjects->count() > 0)
                    @foreach($topProjects as $index => $project)
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                                <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90 truncate">{{ $project->name }}</p>
                                <p class="text-xs text-gray-500">{{ $project->views_count ?? $project->properties_count ?? 0 }} properti</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500 text-center py-8">Belum ada data proyek</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Properties Table -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] mb-6">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Properti Terbaru</h4>
            <a href="{{ route('agent.properties.index') }}" class="text-sm text-brand-500 hover:text-brand-600">
                Lihat Semua <i class="fa fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Properti</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Harga</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @if($recentProperties->count() > 0)
                            @foreach($recentProperties as $property)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('agent.properties.show', $property) }}" class="font-medium text-gray-800 hover:text-brand-500 dark:text-white/90">
                                            {{ $property->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $property->category->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        Rp {{ number_format($property->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($property->is_published)
                                            <span class="rounded-full bg-green-50 px-2 py-0.5 text-xs font-semibold text-green-600">Aktif</span>
                                        @else
                                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-600">Draft</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $property->views ?? 0 }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada properti
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Inquiries -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Inquiry Terbaru</h4>
            <a href="{{ route('agent.properties.index') }}" class="text-sm text-brand-500 hover:text-brand-600">
                Lihat Semua <i class="fa fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="space-y-4">
            @if($recentInquiries->count() > 0)
                @foreach($recentInquiries as $inquiry)
                    <div class="flex items-start gap-4 rounded-xl border border-gray-200 p-4 dark:border-gray-800">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-900/20">
                            <i class="fa fa-user text-brand-500"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h5 class="font-medium text-gray-800 dark:text-white/90">{{ $inquiry->name }}</h5>
                                <span class="text-xs text-gray-500">{{ $inquiry->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-500">{{ $inquiry->email }} - {{ $inquiry->phone }}</p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($inquiry->message, 100) }}</p>
                            @if($inquiry->property)
                                <a href="{{ route('agent.properties.show', $inquiry->property) }}" class="mt-2 inline-block text-xs text-brand-500 hover:text-brand-600">
                                    <i class="fa fa-home mr-1"></i> {{ $inquiry->property->title }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-sm text-gray-500 text-center py-8">Belum ada inquiry</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Views Chart
    const viewsCtx = document.getElementById('viewsChart').getContext('2d');
    new Chart(viewsCtx, {
        type: 'line',
        data: {
            labels: {{ json_encode($viewsChart['labels']) }},
            datasets: [{
                label: 'Views',
                data: {{ json_encode($viewsChart['data']) }},
                borderColor: '#465FFF',
                backgroundColor: 'rgba(70, 95, 255, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Inquiries Chart
    const inquiriesCtx = document.getElementById('inquiriesChart').getContext('2d');
    new Chart(inquiriesCtx, {
        type: 'bar',
        data: {
            labels: {{ json_encode($inquiriesChart['labels']) }},
            datasets: [{
                label: 'Inquiries',
                data: {{ json_encode($inquiriesChart['data']) }},
                backgroundColor: '#F59E0B',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {{ json_encode(array_keys($propertiesByStatus)) }},
            datasets: [{
                data: {{ json_encode(array_values($propertiesByStatus)) }},
                backgroundColor: ['#22C55E', '#6B7280', '#EF4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: {{ json_encode(array_keys($propertiesByCategory)) }},
            datasets: [{
                data: {{ json_encode(array_values($propertiesByCategory)) }},
                backgroundColor: ['#465FFF', '#22C55E', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>
@endpush
