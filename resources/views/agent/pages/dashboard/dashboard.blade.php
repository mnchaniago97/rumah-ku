@extends('agent.layouts.app')

@section('content')
  <script>
    window.__DASHBOARD_DATA__ = @json($dashboardData ?? []);
  </script>

  @php
    $agent = $agentProfile ?? auth()->user();
    $defaultRumahSubsidi = ($agent->agent_type ?? null) === \App\Models\AgentApplication::TYPE_PROPERTY_AGENT;
    $canRumahSubsidi = $agent ? $agent->canAgentFeature('rumah_subsidi', $defaultRumahSubsidi) : false;
  @endphp

  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12 space-y-6 xl:col-span-7">
      <x-ecommerce.ecommerce-metrics :cards="$metricCards ?? []" :counts="$counts ?? []" />
      <x-ecommerce.monthly-sale />
    </div>
    <div class="col-span-12 xl:col-span-5">
        <x-ecommerce.monthly-target :summary="$approvalSummary ?? []" />
    </div>

    <div class="col-span-12 xl:col-span-5">
      <x-ecommerce.customer-demographic :countries="$topCities ?? []" />
    </div>

    <div class="col-span-12 xl:col-span-7">
      <x-ecommerce.recent-orders :products="$recentProperties ?? []" />
    </div>

    @if($canRumahSubsidi)
    <div class="col-span-12">
      <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between gap-3">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Rumah Subsidi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              Total listing Anda: <span class="font-semibold text-gray-900 dark:text-white">{{ $rumahSubsidiCount ?? 0 }}</span>
            </p>
          </div>
          <a href="{{ route('agent.rumah-subsidi.index') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">
            Kelola
          </a>
        </div>

        @if(($rumahSubsidiLatest ?? collect())->count() > 0)
          <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($rumahSubsidiLatest as $property)
              @php
                $thumb = $property->images->sortBy('sort_order')->firstWhere('is_primary', true)?->path
                  ?? $property->images->sortBy('sort_order')->first()?->path;

                if (!empty($thumb) && !str_starts_with($thumb, 'http://') && !str_starts_with($thumb, 'https://') && !str_starts_with($thumb, '/')) {
                    $thumb = '/storage/' . ltrim($thumb, '/');
                }
              @endphp
              <a href="{{ route('agent.rumah-subsidi.show', $property) }}"
                class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-3 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:hover:bg-white/[0.03]">
                <div class="h-12 w-12 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800">
                  @if($thumb)
                    <img src="{{ $thumb }}" alt="{{ $property->title }}" class="h-full w-full object-cover" loading="lazy" />
                  @else
                    <div class="flex h-full w-full items-center justify-center text-xs text-gray-400">No Image</div>
                  @endif
                </div>
                <div class="min-w-0">
                  <div class="truncate text-sm font-semibold text-gray-900 dark:text-white">{{ $property->title }}</div>
                  <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $property->is_approved ? 'Disetujui' : 'Menunggu persetujuan' }}
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </div>
    @endif
  </div>
@endsection
