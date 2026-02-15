@extends('frontend.layouts.app')

@section('content')
  @php
    $developerFallback = ['Partner A','Partner B','Partner C','Partner D','Partner E','Partner F'];
    $agentFallback = ['Agen X','Agen Y','Agen Z','Agen Q','Agen R','Agen S'];
    $bankFallback = ['Bank Mandiri','BRI','BNI','BCA','BTN','CIMB Niaga','OCBC NISP','PermataBank','Maybank','UOB','Danamon','BSI'];
  @endphp
  <div class="bg-white">
    <section class="relative overflow-hidden bg-gradient-to-r from-[#0B2B6B] via-[#0B2B6B] to-[#1E40AF] text-white">
      <div class="absolute inset-0 opacity-15">
        <img src="/assets/frontend/img/welcome-bg.png" alt="bg" class="h-full w-full object-cover" />
      </div>
      <div class="relative mx-auto max-w-[1200px] px-4 py-14">
        <div class="mx-auto max-w-3xl text-center">
          <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/90">
            Partner
          </div>
          <h1 class="mt-4 text-3xl font-bold leading-tight md:text-4xl">
            Kemitraan Strategis untuk Ekosistem Properti yang Lebih Baik
          </h1>
          <p class="mt-3 text-sm text-white/80 md:text-base">
            Bekerja sama dengan developer, agen, dan institusi keuangan untuk pengalaman jual-beli yang lebih mudah.
          </p>

          <div class="mt-7 grid gap-4 sm:grid-cols-3">
            <a href="#developer" class="group rounded-2xl bg-white/10 p-4 text-left ring-1 ring-white/10 hover:bg-white/15">
              <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                  <i class="fa fa-city text-white/90"></i>
                </span>
                <div>
                  <div class="text-sm font-bold">Developer</div>
                  <div class="mt-1 text-xs text-white/70">Proyek & campaign.</div>
                </div>
              </div>
              <div class="mt-3 text-xs font-semibold text-white/90">Lihat →</div>
            </a>
            <a href="#agen" class="group rounded-2xl bg-white/10 p-4 text-left ring-1 ring-white/10 hover:bg-white/15">
              <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                  <i class="fa fa-user-tie text-white/90"></i>
                </span>
                <div>
                  <div class="text-sm font-bold">Agen</div>
                  <div class="mt-1 text-xs text-white/70">Jaringan profesional.</div>
                </div>
              </div>
              <div class="mt-3 text-xs font-semibold text-white/90">Lihat →</div>
            </a>
            <a href="#bank" class="group rounded-2xl bg-white/10 p-4 text-left ring-1 ring-white/10 hover:bg-white/15">
              <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                  <i class="fa fa-landmark text-white/90"></i>
                </span>
                <div>
                  <div class="text-sm font-bold">Bank</div>
                  <div class="mt-1 text-xs text-white/70">KPR & pembiayaan.</div>
                </div>
              </div>
              <div class="mt-3 text-xs font-semibold text-white/90">Lihat →</div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <div class="mx-auto max-w-[1200px] px-4 py-12">
      <section id="developer" class="scroll-mt-24">
        <div class="grid gap-8 md:grid-cols-2 md:items-center">
          <div>
            <h2 class="text-2xl font-bold text-gray-900">Developer Partner</h2>
            <p class="mt-2 text-sm text-gray-600">
              Bersama developer, kami membantu memperluas jangkauan, meningkatkan kualitas leads, dan menguatkan brand proyek.
            </p>
            <div class="mt-6 grid gap-3 sm:grid-cols-2">
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-center gap-3">
                  <i class="fa fa-bullseye text-blue-700"></i>
                  <div class="text-sm font-semibold text-gray-900">Targeted Campaign</div>
                </div>
                <p class="mt-2 text-sm text-gray-600">Segmentasi audience dan kanal promosi sesuai tujuan.</p>
              </div>
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-center gap-3">
                  <i class="fa fa-chart-bar text-emerald-700"></i>
                  <div class="text-sm font-semibold text-gray-900">Reporting</div>
                </div>
                <p class="mt-2 text-sm text-gray-600">Ringkasan performa leads dan listing untuk evaluasi.</p>
              </div>
            </div>
          </div>
          <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-white p-6 ring-1 ring-gray-200">
            <div class="text-sm font-semibold text-gray-900">Contoh Partner</div>
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
              @php $items = ($developerPartners ?? collect()); @endphp
              @if($items->count())
                @foreach($items as $p)
                  <a href="{{ $p->website_url ?: '#' }}"
                    class="flex items-center justify-center rounded-xl bg-white p-3 text-xs font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50"
                    @if($p->website_url) target="_blank" rel="noopener" @endif>
                    @if($p->logo)
                      <img src="{{ Storage::url($p->logo) }}" alt="{{ $p->name }}" class="h-7 w-auto object-contain" />
                    @else
                      {{ $p->name }}
                    @endif
                  </a>
                @endforeach
              @else
                @foreach($developerFallback as $p)
                  <div class="flex items-center justify-center rounded-xl bg-white p-3 text-xs font-semibold text-gray-600 shadow-sm ring-1 ring-gray-200">
                    {{ $p }}
                  </div>
                @endforeach
              @endif
            </div>
            <div class="mt-5 text-sm text-gray-600">
              Ingin tampil sebagai partner? <a href="{{ route('contact') }}" class="font-semibold text-blue-700 hover:text-blue-800">Hubungi kami</a>.
            </div>
          </div>
        </div>
      </section>

      <section id="agen" class="mt-12 scroll-mt-24">
        <div class="grid gap-8 md:grid-cols-2 md:items-center">
          <div class="order-2 md:order-1 rounded-2xl bg-gradient-to-br from-slate-50 to-white p-6 ring-1 ring-gray-200">
            <div class="text-sm font-semibold text-gray-900">Jaringan Agen</div>
            <p class="mt-2 text-sm text-gray-600">
              Kemitraan dengan agen profesional untuk mempercepat proses jual-beli dan meningkatkan kepercayaan.
            </p>
            <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
              @php $items = ($agentPartners ?? collect()); @endphp
              @if($items->count())
                @foreach($items as $p)
                  <a href="{{ $p->website_url ?: '#' }}"
                    class="flex items-center justify-center rounded-xl bg-white p-3 text-xs font-semibold text-gray-700 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50"
                    @if($p->website_url) target="_blank" rel="noopener" @endif>
                    @if($p->logo)
                      <img src="{{ Storage::url($p->logo) }}" alt="{{ $p->name }}" class="h-7 w-auto object-contain" />
                    @else
                      {{ $p->name }}
                    @endif
                  </a>
                @endforeach
              @else
                @foreach($agentFallback as $p)
                  <div class="flex items-center justify-center rounded-xl bg-white p-3 text-xs font-semibold text-gray-600 shadow-sm ring-1 ring-gray-200">
                    {{ $p }}
                  </div>
                @endforeach
              @endif
            </div>
          </div>
          <div class="order-1 md:order-2">
            <h2 class="text-2xl font-bold text-gray-900">Agen Properti Partner</h2>
            <p class="mt-2 text-sm text-gray-600">
              Kolaborasi untuk edukasi, event, dan dukungan operasional agar layanan semakin profesional.
            </p>
            <div class="mt-6 grid gap-3 sm:grid-cols-2">
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-center gap-3">
                  <i class="fa fa-handshake text-amber-600"></i>
                  <div class="text-sm font-semibold text-gray-900">Networking</div>
                </div>
                <p class="mt-2 text-sm text-gray-600">Event kolaborasi dan penguatan komunitas agen.</p>
              </div>
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-center gap-3">
                  <i class="fa fa-graduation-cap text-blue-700"></i>
                  <div class="text-sm font-semibold text-gray-900">Edukasi</div>
                </div>
                <p class="mt-2 text-sm text-gray-600">Materi dan pelatihan untuk meningkatkan kualitas layanan.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="bank" class="mt-12 scroll-mt-24">
        <div class="text-center">
          <h2 class="text-2xl font-bold text-gray-900">Bank Partner Terpercaya</h2>
          <p class="mx-auto mt-2 max-w-2xl text-sm text-gray-600">
            Membantu memberikan opsi pembiayaan dan referensi KPR, termasuk simulasi cicilan untuk pengguna.
          </p>
        </div>

        <div class="mt-7 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-6">
          @php $items = ($bankPartners ?? collect()); @endphp
          @if($items->count())
            @foreach($items as $p)
              <a href="{{ $p->website_url ?: '#' }}"
                class="flex items-center justify-center rounded-xl border border-gray-200 bg-white p-3 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
                @if($p->website_url) target="_blank" rel="noopener" @endif>
                @if($p->logo)
                  <img src="{{ Storage::url($p->logo) }}" alt="{{ $p->name }}" class="h-7 w-auto object-contain" />
                @else
                  {{ $p->name }}
                @endif
              </a>
            @endforeach
          @else
            @foreach($bankFallback as $p)
              <div class="flex items-center justify-center rounded-xl border border-gray-200 bg-white p-3 text-xs font-semibold text-gray-600 shadow-sm">
                {{ $p }}
              </div>
            @endforeach
          @endif
        </div>

        <div class="mt-10 rounded-2xl bg-blue-900 px-6 py-10 text-center text-white md:px-10">
          <h3 class="text-2xl font-bold">Ingin bermitra?</h3>
          <p class="mx-auto mt-2 max-w-2xl text-sm text-blue-100">
            Ceritakan kebutuhan kerja sama Anda. Tim kami akan menghubungi untuk diskusi lebih lanjut.
          </p>
          <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('contact') }}"
              class="inline-flex items-center justify-center rounded-lg bg-white px-6 py-3 text-sm font-semibold text-blue-900 hover:bg-blue-50">
              Hubungi Kami
            </a>
            <a href="{{ route('company.products') }}"
              class="inline-flex items-center justify-center rounded-lg border border-white/30 bg-white/10 px-6 py-3 text-sm font-semibold text-white hover:bg-white/15">
              Lihat Produk & Layanan
            </a>
          </div>
        </div>
      </section>
    </div>
  </div>
@endsection
