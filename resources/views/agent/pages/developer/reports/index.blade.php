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
            <div id="viewsChart"></div>
        </div>

        <!-- Inquiries Chart -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Statistik Inquiries (6 Bulan Terakhir)</h4>
            <div id="inquiriesChart"></div>
        </div>
    </div>

    <!-- Property by Status -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <!-- Properties by Status -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Properti per Status</h4>
            <div id="statusChart"></div>
        </div>

        <!-- Properties by Category -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Properti per Kategori</h4>
            <div id="categoryChart"></div>
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
            @if($recentInquiries->count() > 0)
                <a href="{{ route('agent.developer-inquiries.index') }}" class="text-sm text-brand-500 hover:text-brand-600">
                    Lihat Semua <i class="fa fa-arrow-right ml-1"></i>
                </a>
            @endif
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
                            @if($inquiry->project)
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    <i class="fa fa-building mr-1"></i> {{ $inquiry->project->name }}
                                </p>
                            @endif
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($inquiry->message, 100) }}</p>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $inquiry->status === 'new' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                    {{ $inquiry->status === 'contacted' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $inquiry->status === 'qualified' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $inquiry->status === 'closed' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                                    {{ $inquiry->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                ">
                                    {{ $inquiry->status_label }}
                                </span>
                                @if($inquiry->financing_type)
                                    <span class="text-xs text-gray-400">{{ $inquiry->financing_type_label }}</span>
                                @endif
                            </div>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Views Chart (Area Chart)
    const viewsChartEl = document.getElementById('viewsChart');
    if (viewsChartEl) {
        const viewsChartOptions = {
            series: [{
                name: 'Views',
                data: {!! json_encode($viewsChart['data']) !!}
            }],
            chart: {
                fontFamily: 'Outfit, sans-serif',
                height: 256,
                type: 'area',
                toolbar: {
                    show: false
                }
            },
            colors: ['#465FFF'],
            fill: {
                gradient: {
                    enabled: true,
                    opacityFrom: 0.55,
                    opacityTo: 0
                }
            },
            stroke: {
                curve: 'straight',
                width: 2
            },
            markers: {
                size: 4,
                colors: ['#465FFF'],
                strokeWidth: 0
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            xaxis: {
                categories: {!! json_encode($viewsChart['labels']) !!},
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                title: {
                    style: {
                        fontSize: '0px'
                    }
                },
                labels: {
                    formatter: function(val) {
                        return Math.round(val);
                    }
                }
            },
            tooltip: {
                x: {
                    show: true
                }
            }
        };
        const viewsChart = new ApexCharts(viewsChartEl, viewsChartOptions);
        viewsChart.render();
    }

    // Inquiries Chart (Bar Chart)
    const inquiriesChartEl = document.getElementById('inquiriesChart');
    if (inquiriesChartEl) {
        const inquiriesChartOptions = {
            series: [{
                name: 'Inquiries',
                data: {!! json_encode($inquiriesChart['data']) !!}
            }],
            chart: {
                fontFamily: 'Outfit, sans-serif',
                height: 256,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            colors: ['#F59E0B'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 5,
                    borderRadiusApplication: 'end'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 4,
                colors: ['transparent']
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            xaxis: {
                categories: {!! json_encode($inquiriesChart['labels']) !!},
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                title: {
                    style: {
                        fontSize: '0px'
                    }
                },
                labels: {
                    formatter: function(val) {
                        return Math.round(val);
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                x: {
                    show: true
                }
            }
        };
        const inquiriesChart = new ApexCharts(inquiriesChartEl, inquiriesChartOptions);
        inquiriesChart.render();
    }

    // Status Chart (Donut Chart)
    const statusChartEl = document.getElementById('statusChart');
    if (statusChartEl) {
        const statusData = {!! json_encode(array_values($propertiesByStatus)) !!};
        const totalStatus = statusData.reduce((a, b) => a + b, 0);
        
        const statusChartOptions = {
            series: totalStatus > 0 ? statusData : [1],
            chart: {
                fontFamily: 'Outfit, sans-serif',
                height: 256,
                type: 'donut'
            },
            colors: totalStatus > 0 ? ['#22C55E', '#6B7280', '#EF4444'] : ['#E5E7EB'],
            labels: totalStatus > 0 ? {!! json_encode(array_keys($propertiesByStatus)) !!} : ['Tidak ada data'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                fontWeight: 500
                            },
                            value: {
                                show: true,
                                fontSize: '16px',
                                fontWeight: 600,
                                formatter: function(val) {
                                    return totalStatus > 0 ? val : '0';
                                }
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                fontWeight: 500,
                                formatter: function() {
                                    return totalStatus;
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '12px',
                markers: {
                    radius: 99
                }
            },
            tooltip: {
                enabled: totalStatus > 0
            }
        };
        const statusChart = new ApexCharts(statusChartEl, statusChartOptions);
        statusChart.render();
    }

    // Category Chart (Donut Chart)
    const categoryChartEl = document.getElementById('categoryChart');
    if (categoryChartEl) {
        const categoryData = {!! json_encode(array_values($propertiesByCategory)) !!};
        const totalCategory = categoryData.reduce((a, b) => a + b, 0);
        
        const categoryChartOptions = {
            series: totalCategory > 0 ? categoryData : [1],
            chart: {
                fontFamily: 'Outfit, sans-serif',
                height: 256,
                type: 'donut'
            },
            colors: totalCategory > 0 ? ['#465FFF', '#22C55E', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4'] : ['#E5E7EB'],
            labels: totalCategory > 0 ? {!! json_encode(array_keys($propertiesByCategory)) !!} : ['Tidak ada data'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                fontWeight: 500
                            },
                            value: {
                                show: true,
                                fontSize: '16px',
                                fontWeight: 600,
                                formatter: function(val) {
                                    return totalCategory > 0 ? val : '0';
                                }
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                fontWeight: 500,
                                formatter: function() {
                                    return totalCategory;
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '12px',
                markers: {
                    radius: 99
                }
            },
            tooltip: {
                enabled: totalCategory > 0
            }
        };
        const categoryChart = new ApexCharts(categoryChartEl, categoryChartOptions);
        categoryChart.render();
    }
});
</script>
@endpush
