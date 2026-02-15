@extends('frontend.layouts.app')

@section('content')
  <div class="bg-white">
    <section class="relative overflow-hidden bg-gradient-to-r from-[#0B2B6B] via-[#0B2B6B] to-[#1E40AF] text-white">
      <div class="absolute inset-0 opacity-15">
        <img src="/assets/frontend/img/welcome-bg.png" alt="bg" class="h-full w-full object-cover" />
      </div>
      <div class="relative mx-auto max-w-[1200px] px-4 py-14">
        <div class="mx-auto max-w-3xl text-center">
          <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/90">
            Produk & Layanan
          </div>
          <h1 class="mt-4 text-3xl font-bold leading-tight md:text-4xl">
            Solusi Properti & KPR untuk Semua Kebutuhan
          </h1>
          <p class="mt-3 text-sm text-white/80 md:text-base">
            Dari mencari hunian, promosi listing, hingga simulasi cicilan—semua dalam satu platform.
          </p>

          <div class="mt-7 grid gap-4 sm:grid-cols-3">
            <a href="#pencari" class="group rounded-2xl bg-white/10 p-4 text-left ring-1 ring-white/10 hover:bg-white/15">
              <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                  <i class="fa fa-home text-white/90"></i>
                </span>
                <div>
                  <div class="text-sm font-bold">Pencari Properti</div>
                  <div class="mt-1 text-xs text-white/70">Cari & bandingkan listing.</div>
                </div>
              </div>
              <div class="mt-3 text-xs font-semibold text-white/90">Lihat detail →</div>
            </a>
            <a href="#agen" class="group rounded-2xl bg-white/10 p-4 text-left ring-1 ring-white/10 hover:bg-white/15">
              <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                  <i class="fa fa-user-tie text-white/90"></i>
                </span>
                <div>
                  <div class="text-sm font-bold">Agen</div>
                  <div class="mt-1 text-xs text-white/70">Bangun profil & leads.</div>
                </div>
              </div>
              <div class="mt-3 text-xs font-semibold text-white/90">Lihat detail →</div>
            </a>
            <a href="#developer" class="group rounded-2xl bg-white/10 p-4 text-left ring-1 ring-white/10 hover:bg-white/15">
              <div class="flex items-start gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
                  <i class="fa fa-city text-white/90"></i>
                </span>
                <div>
                  <div class="text-sm font-bold">Developer</div>
                  <div class="mt-1 text-xs text-white/70">Promosi proyek & campaign.</div>
                </div>
              </div>
              <div class="mt-3 text-xs font-semibold text-white/90">Lihat detail →</div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <div class="mx-auto max-w-[1200px] px-4 py-12">
      <section id="pencari" class="scroll-mt-24">
        <div class="grid gap-8 md:grid-cols-2 md:items-center">
          <div>
            <h2 class="text-2xl font-bold text-gray-900">Untuk Pencari Properti</h2>
            <p class="mt-2 text-sm text-gray-600">
              Temukan properti sesuai kebutuhan—lebih cepat, lebih rapi, dan mudah dibandingkan.
            </p>
            <div class="mt-6 grid gap-3">
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3">
                  <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-700"><i class="fa fa-filter"></i></span>
                  <div>
                    <div class="font-semibold text-gray-900">Filter Pencarian</div>
                    <div class="mt-1 text-sm text-gray-600">Lokasi, harga, tipe, luas, hingga fasilitas.</div>
                  </div>
                </div>
              </div>
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3">
                  <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700"><i class="fa fa-bolt"></i></span>
                  <div>
                    <div class="font-semibold text-gray-900">Respons Cepat</div>
                    <div class="mt-1 text-sm text-gray-600">Ajukan pertanyaan & request properti dengan mudah.</div>
                  </div>
                </div>
              </div>
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3">
                  <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-700"><i class="fa fa-calculator"></i></span>
                  <div>
                    <div class="font-semibold text-gray-900">Simulasi KPR</div>
                    <div class="mt-1 text-sm text-gray-600">Hitung estimasi cicilan berdasarkan harga dan tenor.</div>
                    <div class="mt-2">
                      <a href="{{ route('calculator') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Buka Kalkulator →</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-white p-6 ring-1 ring-gray-200">
            <div class="flex items-center justify-between gap-4">
              <div>
                <div class="text-sm font-semibold text-gray-900">Rekomendasi untuk Anda</div>
                <div class="mt-1 text-xs text-gray-600">Mulai dari kebutuhan dasar sampai premium.</div>
              </div>
              <span class="inline-flex items-center rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white">Fitur</span>
            </div>
            <div class="mt-5 grid gap-3">
              <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
                <div class="flex items-center justify-between">
                  <div class="text-sm font-semibold text-gray-900">Listing Terverifikasi</div>
                  <i class="fa fa-check-circle text-emerald-600"></i>
                </div>
                <div class="mt-1 text-xs text-gray-600">Informasi lebih jelas dan nyaman dibandingkan.</div>
              </div>
              <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
                <div class="flex items-center justify-between">
                  <div class="text-sm font-semibold text-gray-900">Favorit & Simpan</div>
                  <i class="fa fa-bookmark text-blue-600"></i>
                </div>
                <div class="mt-1 text-xs text-gray-600">Pantau properti yang Anda incar.</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="agen" class="mt-12 scroll-mt-24">
        <div class="grid gap-8 md:grid-cols-2 md:items-center">
          <div class="order-2 md:order-1 rounded-2xl bg-gradient-to-br from-slate-50 to-white p-6 ring-1 ring-gray-200">
            <div class="text-sm font-semibold text-gray-900">Untuk Agen</div>
            <p class="mt-2 text-sm text-gray-600">
              Tingkatkan kredibilitas dengan profil yang rapi dan tampil menonjol di listing.
            </p>
            <div class="mt-5 grid gap-3">
              <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
                <div class="flex items-center gap-3">
                  <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-700"><i class="fa fa-id-badge"></i></span>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">Profil Profesional</div>
                    <div class="mt-1 text-xs text-gray-600">Bangun kepercayaan calon klien.</div>
                  </div>
                </div>
              </div>
              <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
                <div class="flex items-center gap-3">
                  <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700"><i class="fa fa-chart-line"></i></span>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">Leads & Insight</div>
                    <div class="mt-1 text-xs text-gray-600">Pantau performa dan peluang closing.</div>
                  </div>
                </div>
              </div>
              <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
                <div class="flex items-center gap-3">
                  <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-700"><i class="fa fa-bullhorn"></i></span>
                  <div>
                    <div class="text-sm font-semibold text-gray-900">Paket Promosi</div>
                    <div class="mt-1 text-xs text-gray-600">Naikkan visibilitas listing.</div>
                    <div class="mt-2">
                      <a href="{{ route('pricing.show', ['type' => 'property-agent']) }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Lihat Paket Agen →</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="order-1 md:order-2">
            <h2 class="text-2xl font-bold text-gray-900">Produk untuk Agen Properti</h2>
            <p class="mt-2 text-sm text-gray-600">
              Fitur untuk memperluas jangkauan, mempercepat closing, dan membangun profil profesional.
            </p>
            <div class="mt-6 grid gap-3 sm:grid-cols-2">
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-center gap-3">
                  <i class="fa fa-shield-alt text-blue-700"></i>
                  <div class="text-sm font-semibold text-gray-900">Verifikasi</div>
                </div>
                <p class="mt-2 text-sm text-gray-600">Listing dan profil lebih tepercaya di mata pengguna.</p>
              </div>
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-center gap-3">
                  <i class="fa fa-rocket text-amber-600"></i>
                  <div class="text-sm font-semibold text-gray-900">Boost</div>
                </div>
                <p class="mt-2 text-sm text-gray-600">Dorong visibilitas di pencarian dan rekomendasi.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="developer" class="mt-12 scroll-mt-24">
        <div class="grid gap-8 md:grid-cols-2 md:items-center">
          <div>
            <h2 class="text-2xl font-bold text-gray-900">Layanan untuk Developer</h2>
            <p class="mt-2 text-sm text-gray-600">
              Tampilkan proyek dengan lebih profesional, dukungan campaign, dan reporting yang jelas.
            </p>
            <div class="mt-6 grid gap-3">
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3">
                  <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-700"><i class="fa fa-building"></i></span>
                  <div>
                    <div class="font-semibold text-gray-900">Listing Proyek</div>
                    <div class="mt-1 text-sm text-gray-600">Halaman proyek yang rapi dan informatif.</div>
                  </div>
                </div>
              </div>
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3">
                  <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700"><i class="fa fa-bullseye"></i></span>
                  <div>
                    <div class="font-semibold text-gray-900">Campaign Terintegrasi</div>
                    <div class="mt-1 text-sm text-gray-600">Strategi promosi untuk menjangkau audience yang tepat.</div>
                  </div>
                </div>
              </div>
              <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex items-start gap-3">
                  <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-700"><i class="fa fa-file-alt"></i></span>
                  <div>
                    <div class="font-semibold text-gray-900">Reporting</div>
                    <div class="mt-1 text-sm text-gray-600">Laporan performa listing dan leads untuk evaluasi.</div>
                    <div class="mt-2">
                      <a href="{{ route('pricing.show', ['type' => 'developer']) }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Lihat Paket Developer →</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="rounded-2xl bg-gradient-to-br from-amber-50 to-white p-6 ring-1 ring-gray-200">
            <div class="flex items-center justify-between">
              <div class="text-sm font-semibold text-gray-900">Butuh paket custom?</div>
              <i class="fa fa-handshake text-amber-600"></i>
            </div>
            <p class="mt-2 text-sm text-gray-600">
              Hubungi tim kami untuk kebutuhan kerja sama, campaign, dan integrasi.
            </p>
            <div class="mt-5 flex flex-wrap items-center gap-3">
              <a href="{{ route('contact') }}" class="inline-flex items-center rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                Hubungi Kami
              </a>
              <a href="{{ route('pricing.show', ['type' => 'developer']) }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-900 hover:bg-gray-50">
                Cek Paket
              </a>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
@endsection

