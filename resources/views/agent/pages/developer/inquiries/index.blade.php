@extends('agent.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Inquiry Proyek" />

    <!-- Filters -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari nama, email, atau telepon..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none dark:border-gray-700 dark:bg-gray-800">
            </div>
            <div class="w-48">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none dark:border-gray-700 dark:bg-gray-800">
                    <option value="">Semua Status</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>Baru</option>
                    <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Dihubungi</option>
                    <option value="qualified" {{ request('status') === 'qualified' ? 'selected' : '' }}>Kualifikasi</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition-colors">
                <i class="fa fa-search mr-2"></i>Filter
            </button>
            <a href="{{ route('agent.developer-inquiries.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors dark:border-gray-700 dark:hover:bg-gray-800">
                Reset
            </a>
        </form>
    </div>

    <!-- Status Tabs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('agent.developer-inquiries.index') }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('status') ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300' }}">
            Semua ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('agent.developer-inquiries.index', ['status' => 'new']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'new' ? 'bg-blue-500 text-white' : 'bg-blue-100 text-blue-600 hover:bg-blue-200' }}">
            Baru ({{ $statusCounts['new'] }})
        </a>
        <a href="{{ route('agent.developer-inquiries.index', ['status' => 'contacted']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'contacted' ? 'bg-yellow-500 text-white' : 'bg-yellow-100 text-yellow-600 hover:bg-yellow-200' }}">
            Dihubungi ({{ $statusCounts['contacted'] }})
        </a>
        <a href="{{ route('agent.developer-inquiries.index', ['status' => 'qualified']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'qualified' ? 'bg-green-500 text-white' : 'bg-green-100 text-green-600 hover:bg-green-200' }}">
            Kualifikasi ({{ $statusCounts['qualified'] }})
        </a>
        <a href="{{ route('agent.developer-inquiries.index', ['status' => 'closed']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'closed' ? 'bg-gray-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Selesai ({{ $statusCounts['closed'] }})
        </a>
        <a href="{{ route('agent.developer-inquiries.index', ['status' => 'rejected']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('status') === 'rejected' ? 'bg-red-500 text-white' : 'bg-red-100 text-red-600 hover:bg-red-200' }}">
            Ditolak ({{ $statusCounts['rejected'] }})
        </a>
    </div>

    <!-- Inquiries List -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
        @if($inquiries->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pengirim</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Proyek</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Pesan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tanggal</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach($inquiries as $inquiry)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-900/20">
                                            <i class="fa fa-user text-brand-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800 dark:text-white/90">{{ $inquiry->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $inquiry->phone }}</p>
                                            <p class="text-xs text-gray-400">{{ $inquiry->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($inquiry->project)
                                        <p class="text-sm text-gray-800 dark:text-white/90">{{ $inquiry->project->name }}</p>
                                        @if($inquiry->property_type_interest)
                                            <p class="text-xs text-gray-500">{{ $inquiry->property_type_interest }}</p>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">{{ Str::limit($inquiry->message, 50) }}</p>
                                    @if($inquiry->budget_min || $inquiry->budget_max)
                                        <p class="text-xs text-gray-400 mt-1">
                                            Budget: 
                                            @if($inquiry->budget_min)
                                                Rp {{ number_format($inquiry->budget_min, 0, ',', '.') }}
                                            @endif
                                            @if($inquiry->budget_max)
                                                - Rp {{ number_format($inquiry->budget_max, 0, ',', '.') }}
                                            @endif
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
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
                                        <p class="text-xs text-gray-400 mt-1">{{ $inquiry->financing_type_label }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-500">{{ $inquiry->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $inquiry->created_at->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('agent.developer-inquiries.show', $inquiry->id) }}" 
                                           class="p-2 text-gray-400 hover:text-brand-500 hover:bg-gray-100 rounded-lg transition-colors dark:hover:bg-gray-800"
                                           title="Lihat Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <form action="{{ route('agent.developer-inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Hapus inquiry ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-gray-400 hover:text-red-500 hover:bg-gray-100 rounded-lg transition-colors dark:hover:bg-gray-800"
                                                    title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                {{ $inquiries->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <i class="fa fa-inbox text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-600 dark:text-gray-300 mb-2">Belum ada inquiry</h3>
                <p class="text-sm text-gray-500">Inquiry dari pengunjung akan muncul di sini</p>
            </div>
        @endif
    </div>
@endsection