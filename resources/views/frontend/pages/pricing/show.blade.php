@extends('frontend.layouts.app')

@section('content')
  @php
    $accentBg = $config['accentBg'] ?? 'bg-blue-700';
    $accentHover = $config['accentHover'] ?? 'hover:bg-blue-800';

    $formatRupiah = function ($value) {
        if ($value === null) return 'Hubungi kami';
        if ((float)$value <= 0) return 'Gratis';
        return 'Rp ' . number_format((float)$value, 0, ',', '.');
    };

    $check = function () {
        return '<svg class="h-4 w-4 text-emerald-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.414l-7.5 7.5a1 1 0 01-1.414 0l-3.5-3.5a1 1 0 111.414-1.414L8.5 11.086l6.793-6.796a1 1 0 011.411 0z" clip-rule="evenodd"/></svg>';
    };

    $cross = function () {
        return '<svg class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>';
    };
  @endphp

  <div class="bg-white">
    <section class="relative overflow-hidden bg-gradient-to-r {{ $config['hero_gradient'] ?? 'from-blue-900 via-blue-800 to-blue-700' }} text-white">
      <div class="absolute inset-0 opacity-15">
        <img src="/assets/frontend/img/welcome-bg.png" alt="bg" class="h-full w-full object-cover" />
      </div>
      <div class="relative mx-auto max-w-[1200px] px-4 py-14">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
          <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/90">
              {{ $typeLabel ?? 'Price List' }}
            </div>
            <h1 class="mt-4 text-3xl font-bold leading-tight md:text-4xl">
              {{ $config['hero_title'] ?? 'Pilih Paket' }}
            </h1>
            <p class="mt-3 text-sm text-white/80 md:text-base">
              {{ $config['hero_subtitle'] ?? '' }}
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-3">
              <a href="#paket" class="inline-flex items-center rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-800 hover:bg-blue-50">
                Lihat Paket
              </a>
              <a href="{{ route('join.show', ['type' => $type]) }}"
                class="inline-flex items-center rounded-lg {{ $accentBg }} px-5 py-3 text-sm font-semibold text-white {{ $accentHover }}">
                Daftar / Ajukan Akses
              </a>
            </div>
          </div>

          <div class="hidden lg:block">
            <div class="relative">
              <div class="absolute -left-6 -top-6 h-14 w-14 rounded-full bg-white/10"></div>
              <img src="/assets/frontend/img/pro-ads.jpg" alt="hero" class="h-[260px] w-[460px] rounded-2xl object-cover shadow-2xl ring-1 ring-white/10" />
            </div>
          </div>
        </div>

        <div class="mt-10 grid gap-4 sm:grid-cols-3">
          <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
            <div class="text-xs text-white/70">Jangkauan</div>
            <div class="mt-1 text-lg font-bold">Lebih luas</div>
          </div>
          <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
            <div class="text-xs text-white/70">Leads</div>
            <div class="mt-1 text-lg font-bold">Lebih terarah</div>
          </div>
          <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
            <div class="text-xs text-white/70">Kontrol</div>
            <div class="mt-1 text-lg font-bold">Admin approval</div>
          </div>
        </div>
      </div>
    </section>

    <div class="mx-auto max-w-[1200px] px-4 py-10">
          <div class="mb-8 overflow-x-auto">
          <div class="inline-flex min-w-max gap-2 rounded-xl bg-gray-50 p-2">
            @foreach(($typeOptions ?? []) as $k => $label)
            <a href="{{ route('pricing.show', ['type' => \App\Models\AgentApplication::slugFromType($k)]) }}"
              class="rounded-lg px-4 py-2 text-sm font-semibold transition
                {{ $k === ($typeKey ?? null) ? 'bg-white text-blue-800 shadow' : 'text-gray-600 hover:bg-white hover:text-gray-900' }}">
              {{ $label }}
            </a>
          @endforeach
        </div>
      </div>

      <section id="paket" class="scroll-mt-24">
        <div class="text-center">
          <h2 class="text-2xl font-bold text-gray-900">Beli Paket Iklan Sekarang dan Nikmati Berbagai Keuntungannya</h2>
          <p class="mt-2 text-sm text-gray-600">Pilih paket sesuai kebutuhan. Setelah ajukan akses, admin akan memverifikasi.</p>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-3">
          @foreach(($plans ?? []) as $plan)
            @php
              $highlight = (bool)($plan['highlight'] ?? false);
            @endphp
            <div class="rounded-2xl border {{ $highlight ? 'border-blue-300 shadow-lg' : 'border-gray-200 shadow-sm' }} bg-white p-6">
              <div class="flex items-start justify-between gap-3">
                <div>
                  <div class="text-sm font-bold text-gray-900">{{ $plan['name'] }}</div>
                  <div class="mt-1 text-xs text-gray-500">{{ $plan['subtitle'] ?? ($plan['badge'] ?? '') }}</div>
                </div>
                @if(!empty($plan['badge']))
                  <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                    {{ $plan['badge'] }}
                  </span>
                @endif
              </div>

              <div class="mt-4">
                <div class="text-2xl font-extrabold text-gray-900">{{ $formatRupiah($plan['price'] ?? null) }}</div>
                <div class="mt-1 text-xs text-gray-500">{{ $plan['period'] ?? '' }}</div>
              </div>

              <ul class="mt-5 space-y-2 text-sm text-gray-700">
                @foreach(($plan['features'] ?? []) as $f)
                  <li class="flex items-start gap-2">
                    {!! $check() !!}
                    <span class="leading-5">{{ $f }}</span>
                  </li>
                @endforeach
              </ul>

              <a href="{{ route('join.show', ['type' => $type]) }}{{ !empty($plan['id']) ? ('?plan=' . $plan['id']) : '' }}"
                class="mt-6 inline-flex w-full items-center justify-center rounded-lg {{ $highlight ? ($accentBg . ' ' . $accentHover) : 'bg-gray-900 hover:bg-gray-800' }} px-4 py-2.5 text-sm font-semibold text-white">
                {{ $plan['cta'] ?? 'Pilih Paket' }}
              </a>

              <div class="mt-3 text-center text-xs text-gray-500">
                Admin dapat menyesuaikan akses & fitur sesuai tipe.
              </div>
            </div>
          @endforeach
        </div>
      </section>

      <section class="mt-12">
        <div class="rounded-2xl bg-gradient-to-b from-blue-50 to-white p-6 md:p-8">
          <div class="text-center">
            <h3 class="text-xl font-bold text-gray-900">Perbandingan Paket</h3>
            <p class="mt-2 text-sm text-gray-600">Ringkasan fitur utama untuk memudahkan memilih.</p>
          </div>

          <div class="mt-6 overflow-x-auto rounded-2xl border border-gray-200 bg-white">
            <table class="min-w-[820px] w-full text-sm">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Fitur</th>
                  @foreach(($comparison['cols'] ?? []) as $col)
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">{{ $col['label'] }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                @foreach(($comparison['rows'] ?? []) as $row)
                  <tr>
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $row['label'] }}</td>
                    @foreach(($comparison['cols'] ?? []) as $col)
                      @php
                        $val = $col['values'][$row['key']] ?? false;
                      @endphp
                      <td class="px-4 py-3 text-center">
                        @if(is_bool($val))
                          {!! $val ? $check() : $cross() !!}
                        @else
                          <span class="font-semibold text-gray-800">{{ $val }}</span>
                        @endif
                      </td>
                    @endforeach
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section class="mt-12">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 md:p-8">
          <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
              <h3 class="text-xl font-bold text-gray-900">Pertanyaan Seputar {{ $typeLabel }}</h3>
              <p class="mt-1 text-sm text-gray-600">Jawaban cepat sebelum Anda mengajukan akses.</p>
            </div>
            <a href="{{ route('join.show', ['type' => $type]) }}"
              class="inline-flex items-center justify-center rounded-lg {{ $accentBg }} px-4 py-2.5 text-sm font-semibold text-white {{ $accentHover }}">
              Lanjut Daftar
            </a>
          </div>

          <div class="mt-6 space-y-3" x-data="{ open: 0 }">
            @foreach(($faqs ?? []) as $idx => $faq)
              <div class="rounded-xl border border-gray-200">
                <button type="button" class="flex w-full items-center justify-between gap-3 px-4 py-3 text-left"
                  @click="open = (open === {{ $idx+1 }} ? 0 : {{ $idx+1 }})">
                  <span class="text-sm font-semibold text-gray-900">{{ $faq['q'] }}</span>
                  <span class="text-gray-500" x-text="open === {{ $idx+1 }} ? '−' : '+'"></span>
                </button>
                <div class="px-4 pb-4 text-sm text-gray-600" x-show="open === {{ $idx+1 }}">
                  {{ $faq['a'] }}
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </section>

      <section class="mt-12">
        <div class="rounded-2xl bg-blue-900 px-6 py-10 text-center text-white md:px-10">
          <h3 class="text-2xl font-bold">Siap mulai?</h3>
          <p class="mx-auto mt-2 max-w-2xl text-sm text-blue-100">
            Ajukan akses sesuai tipe. Admin akan meninjau dan mengaktifkan dashboard agent dengan fitur yang sesuai.
          </p>
          <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('join.show', ['type' => $type]) }}"
              class="inline-flex items-center justify-center rounded-lg bg-white px-6 py-3 text-sm font-semibold text-blue-900 hover:bg-blue-50">
              Ajukan Akses Sekarang
            </a>
            <a href="{{ route('contact') }}"
              class="inline-flex items-center justify-center rounded-lg border border-white/30 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15">
              Hubungi Kami
            </a>
          </div>
        </div>
      </section>
    </div>
  </div>
@endsection
