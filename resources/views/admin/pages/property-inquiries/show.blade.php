@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Detail Permintaan</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Calon customer: {{ $inquiry->name }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.property-inquiries.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/[0.03]">
                    Kembali
                </a>
                <form action="{{ route('admin.property-inquiries.destroy', $inquiry) }}" method="POST"
                    onsubmit="return confirm('Hapus permintaan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-500/10 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Customer</h3>
                    <dl class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Nama</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $inquiry->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Telepon</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $inquiry->phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Saya ingin</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $inquiry->intent === 'rent' ? 'Sewa' : 'Beli' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Minat KPR</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $inquiry->wants_kpr ? 'Ya' : 'Tidak' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Lokasi</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $inquiry->location ?: '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Tipe Properti</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">
                                @php
                                    $types = collect($inquiry->property_types ?? [])->filter()->values();
                                @endphp
                                {{ $types->isEmpty() ? '-' : $types->implode(', ') }}
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Kisaran Harga</dt>
                            <dd class="text-sm font-semibold text-gray-900 dark:text-white">
                                @php
                                    $min = $inquiry->price_min ? 'Rp ' . number_format((float)$inquiry->price_min, 0, ',', '.') : null;
                                    $max = $inquiry->price_max ? 'Rp ' . number_format((float)$inquiry->price_max, 0, ',', '.') : null;
                                @endphp
                                {{ $min && $max ? "{$min} - {$max}" : ($min ?: ($max ?: '-')) }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Catatan</h3>
                    <div class="mt-3 text-sm text-gray-700 dark:text-gray-200 whitespace-pre-line">
                        {{ $inquiry->notes ?: '-' }}
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Status & Tindak Lanjut</h3>

                    <form action="{{ route('admin.property-inquiries.update', $inquiry) }}" method="POST" class="mt-4 space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                                <option value="new" @selected($inquiry->status === 'new')>Baru</option>
                                <option value="contacted" @selected($inquiry->status === 'contacted')>Sudah Dihubungi</option>
                                <option value="closed" @selected($inquiry->status === 'closed')>Selesai</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan Admin</label>
                            <textarea name="notes" rows="4"
                                class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('notes', $inquiry->notes) }}</textarea>
                        </div>

                        <button type="submit" class="w-full rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-600">
                            Simpan
                        </button>
                    </form>

                    <div class="mt-4 text-xs text-gray-500 dark:text-gray-400 space-y-1">
                        <div>Dibuat: {{ $inquiry->created_at?->format('d M Y H:i') }}</div>
                        <div>Dihubungi: {{ $inquiry->contacted_at?->format('d M Y H:i') ?: '-' }}</div>
                        <div>Ditangani oleh: {{ $inquiry->handler?->name ?: '-' }}</div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Teknis</h3>
                    <dl class="mt-3 space-y-3 text-sm">
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Referrer</dt>
                            <dd class="text-gray-700 dark:text-gray-200 break-all">{{ $inquiry->referrer ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">IP</dt>
                            <dd class="text-gray-700 dark:text-gray-200">{{ $inquiry->ip_address ?: '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">User Agent</dt>
                            <dd class="text-gray-700 dark:text-gray-200 break-words">{{ $inquiry->user_agent ?: '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection

