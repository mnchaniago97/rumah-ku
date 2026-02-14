@extends('admin.layouts.app')

@section('content')
  <div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Pendaftaran Agent</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Permohonan akses dashboard agent berdasarkan tipe pendaftaran.</p>
      </div>

      <form method="GET" class="flex flex-wrap items-center gap-2">
        <select name="status" class="h-10 rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
          <option value="">Semua Status</option>
          <option value="pending" @selected(($status ?? null) === 'pending')>Pending</option>
          <option value="approved" @selected(($status ?? null) === 'approved')>Approved</option>
          <option value="rejected" @selected(($status ?? null) === 'rejected')>Rejected</option>
        </select>

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
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Pemohon</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Tipe</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Paket</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Status</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300">Tanggal</th>
              <th class="px-4 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($applications as $app)
              <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.03]">
                <td class="px-4 py-3">
                  <div class="font-semibold text-gray-900 dark:text-white">{{ $app->name }}</div>
                  <div class="text-xs text-gray-500 dark:text-gray-400">{{ $app->email ?? ($app->user?->email ?? '-') }}</div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                  {{ ($typeOptions[$app->requested_type] ?? $app->requested_type) }}
                  @if($app->approved_type)
                    <div class="text-xs text-gray-500 dark:text-gray-400">Disetujui: {{ $typeOptions[$app->approved_type] ?? $app->approved_type }}</div>
                  @endif
                </td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                  @php
                    $reqPlan = $app->requestedPlan?->name;
                    $apprPlan = $app->approvedPlan?->name;
                  @endphp
                  {{ $reqPlan ?? '-' }}
                  @if($apprPlan)
                    <div class="text-xs text-gray-500 dark:text-gray-400">Disetujui: {{ $apprPlan }}</div>
                  @endif
                </td>
                <td class="px-4 py-3">
                  @php
                    $badge = match($app->status) {
                      'approved' => 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-300',
                      'rejected' => 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-300',
                      default => 'bg-yellow-50 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-300',
                    };
                    $label = match($app->status) {
                      'approved' => 'Approved',
                      'rejected' => 'Rejected',
                      default => 'Pending',
                    };
                  @endphp
                  <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $badge }}">
                    {{ $label }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                  {{ $app->created_at?->format('d M Y H:i') }}
                </td>
                <td class="px-4 py-3 text-right">
                  <a href="{{ route('admin.agent-applications.show', $app) }}"
                    class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/[0.03]">
                    Detail
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                  Belum ada pendaftaran.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div>
      {{ $applications->links() }}
    </div>
  </div>
@endsection
