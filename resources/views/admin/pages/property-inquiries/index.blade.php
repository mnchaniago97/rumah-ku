@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Permintaan Properti</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Data calon customer yang minta dibantu carikan properti.</p>
            </div>

            <form method="GET" class="flex items-center gap-2">
                <select name="status" class="h-10 rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="new" @selected(($status ?? null) === 'new')>Baru</option>
                    <option value="contacted" @selected(($status ?? null) === 'contacted')>Sudah Dihubungi</option>
                    <option value="closed" @selected(($status ?? null) === 'closed')>Selesai</option>
                </select>
                <button type="submit" class="h-10 rounded-lg bg-brand-500 px-4 text-sm font-semibold text-white hover:bg-brand-600">
                    Filter
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-500/10 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="max-w-full overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800/40">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Telepon</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Lokasi</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Harga</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Tanggal</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($inquiries as $inquiry)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.03]">
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-gray-900 dark:text-white">{{ $inquiry->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $inquiry->intent === 'rent' ? 'Sewa' : 'Beli' }}
                                        @if($inquiry->wants_kpr)
                                            · KPR
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $inquiry->phone }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $inquiry->location ?: '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    @php
                                        $min = $inquiry->price_min ? 'Rp ' . number_format((float)$inquiry->price_min, 0, ',', '.') : null;
                                        $max = $inquiry->price_max ? 'Rp ' . number_format((float)$inquiry->price_max, 0, ',', '.') : null;
                                    @endphp
                                    {{ $min && $max ? "{$min} - {$max}" : ($min ?: ($max ?: '-')) }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $badge = match($inquiry->status) {
                                            'contacted' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-300',
                                            'closed' => 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-300',
                                            default => 'bg-yellow-50 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-300',
                                        };
                                        $label = match($inquiry->status) {
                                            'contacted' => 'Sudah Dihubungi',
                                            'closed' => 'Selesai',
                                            default => 'Baru',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $badge }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $inquiry->created_at?->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.property-inquiries.show', $inquiry) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/[0.03]">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Belum ada data permintaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $inquiries->links() }}
        </div>
    </div>
@endsection

