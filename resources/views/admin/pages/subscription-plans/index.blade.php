@extends('admin.layouts.app')

@section('content')
  <div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Pricing / Paket Langganan</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola paket langganan per tipe agent (harga, akses, fitur).</p>
      </div>

      <div class="flex flex-wrap items-center gap-2">
        <form method="GET" class="flex items-center gap-2">
          <select name="type" class="h-10 rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
            <option value="">Semua Tipe</option>
            @foreach(($typeOptions ?? []) as $k => $label)
              <option value="{{ $k }}" @selected(($type ?? null) === $k)>{{ $label }}</option>
            @endforeach
          </select>
          <button type="submit" class="h-10 rounded-lg bg-brand-500 px-4 text-sm font-semibold text-white hover:bg-brand-600">
            Filter
          </button>
        </form>

        <a href="{{ route('admin.subscription-plans.create', ['type' => $type]) }}"
          class="h-10 inline-flex items-center rounded-lg bg-gray-900 px-4 text-sm font-semibold text-white hover:bg-gray-800">
          Tambah Paket
        </a>
      </div>
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
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Tipe</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Paket</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Harga</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Status</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Urutan</th>
              <th class="px-4 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($plans as $plan)
              <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.03]">
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                  {{ ($typeOptions[$plan->agent_type] ?? $plan->agent_type) }}
                </td>
                <td class="px-4 py-3">
                  <div class="font-semibold text-gray-900 dark:text-white">{{ $plan->name }}</div>
                  <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $plan->badge ?? '-' }} @if($plan->is_highlight) · Highlight @endif
                  </div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                  {{ $plan->formattedPrice() }}
                  @if($plan->period_label)
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $plan->period_label }}</div>
                  @endif
                </td>
                <td class="px-4 py-3">
                  @if($plan->is_active)
                    <span class="inline-flex rounded-full bg-green-50 px-2 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-300">Aktif</span>
                  @else
                    <span class="inline-flex rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-300">Nonaktif</span>
                  @endif
                </td>
                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $plan->sort_order }}</td>
                <td class="px-4 py-3 text-right">
                  <div class="inline-flex items-center gap-2">
                    <a href="{{ route('admin.subscription-plans.edit', $plan) }}"
                      class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/[0.03]">
                      Edit
                    </a>
                    <form method="POST" action="{{ route('admin.subscription-plans.destroy', $plan) }}" onsubmit="return confirm('Hapus paket ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100 dark:border-red-900/40 dark:bg-red-500/10 dark:text-red-300">
                        Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                  Belum ada paket. Klik "Tambah Paket" untuk membuat paket pertama.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div>
      {{ $plans->links() }}
    </div>
  </div>
@endsection

