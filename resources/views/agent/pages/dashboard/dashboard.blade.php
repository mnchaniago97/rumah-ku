@extends('agent.layouts.app')

@section('content')
  <div class="grid grid-cols-12 gap-4 md:gap-6">
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

    <div class="col-span-12">
      <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
        <div class="flex flex-wrap items-center justify-between gap-3">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Agent</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Lengkapi identitas Anda agar tampil profesional di halaman agen.</p>
          </div>
          @if(isset($agentProfile) && $agentProfile)
            <a href="{{ route('agent.users.show', $agentProfile) }}"
              class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
              Edit Profil
            </a>
          @endif
        </div>

        @php
          $agent = $agentProfile ?? auth()->user();
        @endphp

        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
          <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-800">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">🪪 Identitas Dasar</h3>
            <dl class="mt-3 space-y-2 text-sm">
              <div class="flex justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">Nama lengkap (KTP)</dt>
                <dd class="text-gray-900 dark:text-white text-right">{{ $agent->ktp_full_name ?? '-' }}</dd>
              </div>
              <div class="flex justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">No. HP / WhatsApp</dt>
                <dd class="text-gray-900 dark:text-white text-right">{{ $agent->whatsapp_phone ?? ($agent->phone ?? '-') }}</dd>
              </div>
              <div class="flex justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">Email profesional</dt>
                <dd class="text-gray-900 dark:text-white text-right">{{ $agent->professional_email ?? '-' }}</dd>
              </div>
              <div class="flex justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">Domisili / area kerja</dt>
                <dd class="text-gray-900 dark:text-white text-right">{{ $agent->domicile_area ?? '-' }}</dd>
              </div>
            </dl>
          </div>

          <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-800">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">🧑‍💼 Identitas Profesi</h3>
            <dl class="mt-3 space-y-2 text-sm">
              <div class="flex justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">Kantor / brand</dt>
                <dd class="text-gray-900 dark:text-white text-right">{{ $agent->agency_brand ?? '-' }}</dd>
              </div>
              <div class="flex justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">Jabatan</dt>
                <dd class="text-gray-900 dark:text-white text-right">{{ $agent->job_title ?? '-' }}</dd>
              </div>
              <div class="flex justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">No. registrasi</dt>
                <dd class="text-gray-900 dark:text-white text-right">{{ $agent->agent_registration_number ?? '-' }}</dd>
              </div>
              <div class="flex justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">Pengalaman</dt>
                <dd class="text-gray-900 dark:text-white text-right">
                  {{ filled($agent->experience_years) ? ($agent->experience_years . ' tahun') : '-' }}
                </dd>
              </div>
              <div class="flex justify-between gap-4">
                <dt class="text-gray-500 dark:text-gray-400">Spesialis area</dt>
                <dd class="text-gray-900 dark:text-white text-right">{{ $agent->specialization_areas ?? '-' }}</dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
    </div>

    <div class="col-span-12 space-y-6 xl:col-span-7">
      <x-ecommerce.ecommerce-metrics />
      <x-ecommerce.monthly-sale />
    </div>
    <div class="col-span-12 xl:col-span-5">
        <x-ecommerce.monthly-target />
    </div>

    <div class="col-span-12">
      <x-ecommerce.statistics-chart />
    </div>

    <div class="col-span-12 xl:col-span-5">
      <x-ecommerce.customer-demographic />
    </div>

    <div class="col-span-12 xl:col-span-7">
      <x-ecommerce.recent-orders />
    </div>
  </div>
@endsection
