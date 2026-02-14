@extends('admin.layouts.app')

@section('content')
  <div class="space-y-6">
    <div class="flex items-center justify-between gap-3">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Detail Pendaftaran</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Review data pemohon, lalu approve/reject.</p>
      </div>
      <a href="{{ route('admin.agent-applications.index') }}" class="text-sm font-semibold text-gray-700 hover:underline dark:text-gray-200">
        Kembali
      </a>
    </div>

    @if (session('success'))
      <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-500/10 dark:text-green-300">
        {{ session('success') }}
      </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
      <div class="lg:col-span-2 space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <div class="text-xs text-gray-500 dark:text-gray-400">Nama</div>
              <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $application->name }}</div>
            </div>
            <div>
              <div class="text-xs text-gray-500 dark:text-gray-400">Email</div>
              <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $application->email ?? $application->user?->email ?? '-' }}</div>
            </div>
            <div>
              <div class="text-xs text-gray-500 dark:text-gray-400">Telepon</div>
              <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $application->phone ?? '-' }}</div>
            </div>
            <div>
              <div class="text-xs text-gray-500 dark:text-gray-400">WhatsApp</div>
              <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $application->whatsapp_phone ?? '-' }}</div>
            </div>
            <div>
              <div class="text-xs text-gray-500 dark:text-gray-400">Domisili</div>
              <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $application->domicile_area ?? '-' }}</div>
            </div>
            <div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Tipe Pendaftaran</div>
            <div class="text-sm font-semibold text-gray-900 dark:text-white">
                {{ ($typeOptions[$application->requested_type] ?? $application->requested_type) }}
            </div>
          </div>
          <div>
            <div class="text-xs text-gray-500 dark:text-gray-400">Paket Dipilih</div>
            <div class="text-sm font-semibold text-gray-900 dark:text-white">
              {{ $application->requestedPlan?->name ?? '-' }}
            </div>
          </div>
        </div>

          @if(!empty($application->payload))
            <div class="mt-6">
              <div class="text-sm font-semibold text-gray-900 dark:text-white">Data Tambahan</div>
              <div class="mt-3 grid gap-3 md:grid-cols-2">
                @foreach($application->payload as $k => $v)
                  <div class="rounded-lg border border-gray-100 bg-gray-50 p-3 text-sm dark:border-gray-800 dark:bg-gray-800/30">
                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">{{ str_replace('_', ' ', $k) }}</div>
                    <div class="mt-1 text-gray-900 dark:text-white break-words">
                      {{ is_array($v) ? json_encode($v) : (string)$v }}
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>

      <div class="lg:col-span-1 space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
          <div class="text-sm font-semibold text-gray-900 dark:text-white">Status</div>
          <div class="mt-2 text-sm text-gray-700 dark:text-gray-200">
            <div>Current: <span class="font-semibold">{{ $application->status }}</span></div>
            @if($application->approved_at)
              <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Approved at: {{ $application->approved_at->format('d M Y H:i') }}</div>
            @endif
            @if($application->rejected_at)
              <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">Rejected at: {{ $application->rejected_at->format('d M Y H:i') }}</div>
            @endif
          </div>
        </div>

        @if($application->status === \App\Models\AgentApplication::STATUS_PENDING)
          <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="text-sm font-semibold text-gray-900 dark:text-white">Approve</div>
            <form method="POST" action="{{ route('admin.agent-applications.approve', $application) }}" class="mt-4 space-y-3">
              @csrf
              @method('PATCH')

              <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Tipe yang disetujui</label>
                <select name="approved_type" class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                  <option value="">Ikuti pendaftaran</option>
                  @foreach(($typeOptions ?? []) as $k => $label)
                    <option value="{{ $k }}">{{ $label }}</option>
                  @endforeach
                </select>
              </div>

              <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Paket yang disetujui</label>
                <select name="approved_plan_id" class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                  <option value="">Ikuti paket yang dipilih</option>
                  @foreach(($plans ?? collect()) as $plan)
                    <option value="{{ $plan->id }}">{{ $plan->name }} ({{ $plan->formattedPrice() }}{{ $plan->period_label ? ' · ' . $plan->period_label : '' }})</option>
                  @endforeach
                </select>
                @error('approved_plan_id')
                  <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                @enderror
              </div>

              <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Catatan Admin (opsional)</label>
                <textarea name="admin_note" rows="3" class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white"></textarea>
              </div>

              <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
                Approve
              </button>
            </form>
          </div>

          <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="text-sm font-semibold text-gray-900 dark:text-white">Reject</div>
            <form method="POST" action="{{ route('admin.agent-applications.reject', $application) }}" class="mt-4 space-y-3">
              @csrf
              @method('PATCH')
              <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Catatan Admin (opsional)</label>
                <textarea name="admin_note" rows="3" class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white"></textarea>
              </div>
              <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                Reject
              </button>
            </form>
          </div>
        @else
          <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="text-sm font-semibold text-gray-900 dark:text-white">Hasil</div>
            <div class="mt-3 text-sm text-gray-700 dark:text-gray-200">
              <div>Tipe disetujui: <span class="font-semibold">{{ $typeOptions[$application->approved_type] ?? ($application->approved_type ?? '-') }}</span></div>
              <div class="mt-2">Paket disetujui: <span class="font-semibold">{{ $application->approvedPlan?->name ?? '-' }}</span></div>
              <div class="mt-2">Catatan: <span class="font-semibold">{{ $application->admin_note ?? '-' }}</span></div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
