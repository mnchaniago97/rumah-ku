@extends('frontend.layouts.app')

@section('content')
  <div class="bg-white">
    <section class="relative overflow-hidden bg-gradient-to-r from-blue-900 via-blue-800 to-blue-700 text-white">
      <div class="absolute inset-0 opacity-15">
        <img src="/assets/frontend/img/welcome-bg.png" alt="bg" class="h-full w-full object-cover" />
      </div>
      <div class="relative mx-auto max-w-[1200px] px-4 py-14">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
          <div class="max-w-2xl">
            <h1 class="text-3xl font-bold leading-tight md:text-4xl">
              {{ $config['hero_title'] ?? ($typeLabel ?? 'Pendaftaran') }}
            </h1>
            <p class="mt-3 text-sm text-blue-100 md:text-base">
              {{ $config['hero_subtitle'] ?? '' }}
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-3">
              <a href="#form"
                class="inline-flex items-center rounded-lg bg-white px-5 py-3 text-sm font-semibold text-blue-700 hover:bg-blue-50">
                {{ $config['cta_label'] ?? 'Daftar' }}
              </a>
              @auth
                <span class="text-xs text-blue-100">Login sebagai: {{ auth()->user()->email }}</span>
              @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-100 hover:text-white">Sudah punya akun? Login</a>
              @endauth
            </div>
          </div>

          <div class="hidden lg:block">
            <img src="/assets/frontend/img/pro-ads.jpg" alt="hero" class="h-[240px] w-[420px] rounded-2xl object-cover shadow-lg" />
          </div>
        </div>
      </div>
    </section>

    <div class="mx-auto max-w-[1200px] px-4 py-10">
      <div class="mb-8 overflow-x-auto">
        <div class="inline-flex min-w-max gap-2 rounded-xl bg-gray-50 p-2">
          @foreach(($typeOptions ?? []) as $k => $label)
            <a href="{{ route('join.show', ['type' => \App\Models\AgentApplication::slugFromType($k)]) }}"
              class="rounded-lg px-4 py-2 text-sm font-semibold transition
                {{ $k === ($typeKey ?? null) ? 'bg-white text-blue-700 shadow' : 'text-gray-600 hover:bg-white hover:text-gray-900' }}">
              {{ $label }}
            </a>
          @endforeach
        </div>
      </div>

      @if (session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
          {{ session('success') }}
        </div>
      @endif

      <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
          <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-gray-900">Keuntungan Bergabung</h2>
            <p class="mt-1 text-sm text-gray-600">Fitur dashboard akan disesuaikan oleh admin sesuai tipe Anda.</p>

            <div class="mt-5 grid gap-4 sm:grid-cols-2">
              <div class="rounded-xl bg-gray-50 p-4">
                <div class="text-sm font-semibold text-gray-900">Kelola listing</div>
                <div class="mt-1 text-sm text-gray-600">Tambah, edit, dan pantau performa listing Anda.</div>
              </div>
              <div class="rounded-xl bg-gray-50 p-4">
                <div class="text-sm font-semibold text-gray-900">Leads lebih terarah</div>
                <div class="mt-1 text-sm text-gray-600">Terima inquiry dan follow up lebih cepat.</div>
              </div>
              <div class="rounded-xl bg-gray-50 p-4">
                <div class="text-sm font-semibold text-gray-900">Profil profesional</div>
                <div class="mt-1 text-sm text-gray-600">Tampil lebih meyakinkan untuk calon klien.</div>
              </div>
              <div class="rounded-xl bg-gray-50 p-4">
                <div class="text-sm font-semibold text-gray-900">Kontrol akses</div>
                <div class="mt-1 text-sm text-gray-600">Admin menentukan role/fitur sesuai pendaftaran.</div>
              </div>
            </div>
          </div>

          <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm" id="form">
            <h2 class="text-xl font-bold text-gray-900">Form Pendaftaran</h2>
            <p class="mt-1 text-sm text-gray-600">Data ini masuk ke dashboard admin untuk diverifikasi.</p>

            <form method="POST" action="{{ route('join.store', ['type' => $type]) }}" class="mt-6 space-y-4">
              @csrf

              <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <div class="flex flex-wrap items-end justify-between gap-2">
                  <div>
                    <div class="text-sm font-bold text-gray-900">Pilih Paket Langganan</div>
                    <div class="mt-1 text-sm text-gray-600">Paket & harga dikelola admin. Akses dashboard akan mengikuti paket yang disetujui.</div>
                  </div>
                  <a href="{{ route('pricing.show', ['type' => $type]) }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">
                    Lihat price list
                  </a>
                </div>

                @if(($plans ?? collect())->count() > 0)
                  <div class="mt-4">
                    <label class="text-sm font-semibold text-gray-700">Paket</label>
                    <select name="subscription_plan_id"
                      class="mt-2 h-11 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm focus:border-blue-500 focus:outline-none">
                      <option value="">Pilih paket</option>
                      @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" @selected((int)old('subscription_plan_id', $prefillPlanId ?? null) === (int)$plan->id)>
                          {{ $plan->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                @else
                  <div class="mt-4 rounded-lg border border-yellow-200 bg-yellow-50 p-3 text-sm text-yellow-800">
                    Paket untuk tipe ini belum tersedia. Silakan hubungi admin.
                  </div>
                @endif

                @error('subscription_plan_id')
                  <div class="mt-2 text-xs text-red-600">{{ $message }}</div>
                @enderror
              </div>

              <div class="grid gap-4 md:grid-cols-2">
                <div>
                  <label class="text-sm font-semibold text-gray-700">Nama Lengkap</label>
                  <input name="full_name" value="{{ old('full_name', auth()->user()?->ktp_full_name ?? auth()->user()?->name ?? '') }}"
                    class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                  @error('full_name')
                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                  @enderror
                </div>
                <div>
                  <label class="text-sm font-semibold text-gray-700">Domisili / Area</label>
                  <input name="domicile_area" value="{{ old('domicile_area', auth()->user()?->domicile_area ?? '') }}"
                    class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                  @error('domicile_area')
                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="grid gap-4 md:grid-cols-2">
                <div>
                  <label class="text-sm font-semibold text-gray-700">No. HP</label>
                  <input name="phone" value="{{ old('phone', auth()->user()?->phone ?? '') }}"
                    class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                  @error('phone')
                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                  @enderror
                </div>
                <div>
                  <label class="text-sm font-semibold text-gray-700">WhatsApp</label>
                  <input name="whatsapp_phone" value="{{ old('whatsapp_phone', auth()->user()?->whatsapp_phone ?? '') }}"
                    class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                  @error('whatsapp_phone')
                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              @guest
                <div class="grid gap-4 md:grid-cols-2">
                  <div>
                    <label class="text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                      class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    @error('email')
                      <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                  </div>
                  <div></div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                  <div>
                    <label class="text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password"
                      class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    @error('password')
                      <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                  </div>
                  <div>
                    <label class="text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                      class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                  </div>
                </div>
              @endguest

              @if(($typeKey ?? null) === \App\Models\AgentApplication::TYPE_PROPERTY_AGENT)
                <div class="rounded-xl bg-gray-50 p-4">
                  <div class="text-sm font-bold text-gray-900">Data Agen</div>
                  <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Kantor / Brand</label>
                      <input name="agency_brand" value="{{ old('agency_brand') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Jabatan</label>
                      <input name="job_title" value="{{ old('job_title') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">No. Registrasi</label>
                      <input name="agent_registration_number" value="{{ old('agent_registration_number') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Pengalaman (tahun)</label>
                      <input type="number" min="0" max="80" name="experience_years" value="{{ old('experience_years') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div class="md:col-span-2">
                      <label class="text-sm font-semibold text-gray-700">Spesialis Area</label>
                      <textarea name="specialization_areas" rows="2"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ old('specialization_areas') }}</textarea>
                    </div>
                  </div>
                </div>
              @elseif(($typeKey ?? null) === \App\Models\AgentApplication::TYPE_IN_HOUSE_MARKETING)
                <div class="rounded-xl bg-gray-50 p-4">
                  <div class="text-sm font-bold text-gray-900">Data In-House Marketing</div>
                  <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Nama Perusahaan</label>
                      <input name="company_name" value="{{ old('company_name') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Posisi</label>
                      <input name="position" value="{{ old('position') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Area Kerja</label>
                      <input name="work_area" value="{{ old('work_area') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Portofolio (URL)</label>
                      <input name="portfolio_url" value="{{ old('portfolio_url') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                  </div>
                </div>
              @elseif(($typeKey ?? null) === \App\Models\AgentApplication::TYPE_PROPERTY_OWNER)
                <div class="rounded-xl bg-gray-50 p-4">
                  <div class="text-sm font-bold text-gray-900">Data Properti</div>
                  <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Lokasi Properti</label>
                      <input name="property_location" value="{{ old('property_location') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Jenis Properti</label>
                      <input name="property_kind" value="{{ old('property_kind') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Tujuan</label>
                      <select name="intent"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">Pilih</option>
                        <option value="sell" @selected(old('intent') === 'sell')>Jual</option>
                        <option value="rent" @selected(old('intent') === 'rent')>Sewakan</option>
                      </select>
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Perkiraan Harga (angka)</label>
                      <input type="number" min="0" name="approx_price" value="{{ old('approx_price') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                  </div>
                </div>
              @elseif(($typeKey ?? null) === \App\Models\AgentApplication::TYPE_DEVELOPER)
                <div class="rounded-xl bg-gray-50 p-4">
                  <div class="text-sm font-bold text-gray-900">Data Developer</div>
                  <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Nama Perusahaan</label>
                      <input name="company_name" value="{{ old('company_name') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Nama Proyek</label>
                      <input name="project_name" value="{{ old('project_name') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Lokasi Proyek</label>
                      <input name="project_location" value="{{ old('project_location') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div>
                      <label class="text-sm font-semibold text-gray-700">Estimasi Unit</label>
                      <input type="number" min="0" name="units_estimate" value="{{ old('units_estimate') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                    <div class="md:col-span-2">
                      <label class="text-sm font-semibold text-gray-700">Website (URL)</label>
                      <input name="website_url" value="{{ old('website_url') }}"
                        class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none" />
                    </div>
                  </div>
                </div>
              @endif

              <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                Kirim Pendaftaran
              </button>
            </form>
          </div>
        </div>

        <div class="lg:col-span-1">
          <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-bold text-gray-900">Alur Persetujuan</div>
            <ol class="mt-4 space-y-3 text-sm text-gray-700">
              <li class="flex gap-3"><span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-700">1</span> Isi form pendaftaran sesuai halaman.</li>
              <li class="flex gap-3"><span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-700">2</span> Data masuk ke dashboard admin.</li>
              <li class="flex gap-3"><span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-700">3</span> Admin menyetujui dan menentukan tipe/fitur.</li>
              <li class="flex gap-3"><span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-blue-700">4</span> Akun Anda otomatis mendapat akses dashboard agent.</li>
            </ol>
          </div>

          <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="text-sm font-bold text-gray-900">FAQ Singkat</div>
            <div class="mt-4 space-y-3 text-sm text-gray-700">
              <div>
                <div class="font-semibold">Kapan akun aktif?</div>
                <div class="mt-1 text-gray-600">Setelah admin menyetujui pendaftaran Anda.</div>
              </div>
              <div>
                <div class="font-semibold">Apakah fitur sama?</div>
                <div class="mt-1 text-gray-600">Tidak. Admin menentukan fitur berdasarkan tipe agent.</div>
              </div>
              <div>
                <div class="font-semibold">Butuh bantuan?</div>
                <div class="mt-1 text-gray-600">Hubungi kami via halaman Contact.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
