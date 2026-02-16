@extends('agent.layouts.app')

@section('content')
    @php
        $isDeveloper = $user?->agent_type === \App\Models\AgentApplication::TYPE_DEVELOPER;
    @endphp

    <x-common.page-breadcrumb pageTitle="Profil Saya" />

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Profil Saya</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Lengkapi identitas Anda agar tampil profesional di halaman agen.</p>
            </div>
            <a href="{{ route('agent.users.show', auth()->id()) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                Edit Profil
            </a>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Identitas Dasar</h4>
                <dl class="mt-5 space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Nama lengkap (KTP)</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->ktp_full_name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Status verifikasi</dt>
                        <dd class="text-right">
                            @if(!empty($user?->agent_verified_at))
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200">
                                    <i class="fa fa-circle-check"></i>
                                    Verified
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                                    <i class="fa fa-circle-xmark"></i>
                                    Belum verified
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">No. HP / WhatsApp</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->whatsapp_phone ?? ($user?->phone ?? '-') }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Email profesional</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->professional_email ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Domisili / area kerja</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->domicile_area ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Identitas Profesi</h4>
                <dl class="mt-5 space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Kantor / brand</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->agency_brand ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Jabatan</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->job_title ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">No. registrasi</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->agent_registration_number ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Pengalaman</dt>
                        <dd class="text-gray-900 dark:text-white text-right">
                            {{ filled($user?->experience_years) ? ($user?->experience_years . ' tahun') : '-' }}
                        </dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Spesialis area</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->specialization_areas ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        @if($isDeveloper)
        <!-- Developer Company Profile Section -->
        <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 p-5 dark:border-blue-800 dark:bg-blue-900/20 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Data Perusahaan Developer</h4>
                <a href="{{ route('agent.users.show', auth()->id()) }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-blue-300 bg-white px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100 dark:border-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                    <i class="fa fa-edit"></i>
                    Edit Perusahaan
                </a>
            </div>
            
            <div class="flex items-start gap-4 mb-4">
                @if($user?->company_logo)
                    <div class="h-16 w-16 overflow-hidden rounded-lg bg-white border border-gray-200">
                        <img src="{{ $user->company_logo }}" alt="{{ $user->company_name }}" class="h-full w-full object-cover">
                    </div>
                @else
                    <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                        <i class="fa fa-building text-gray-400 text-xl"></i>
                    </div>
                @endif
                <div class="flex-1">
                    <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user?->company_name ?? 'Nama Perusahaan' }}</h5>
                    @if($user?->company_website)
                        <a href="{{ $user->company_website }}" target="_blank" class="text-sm text-blue-600 hover:underline">
                            <i class="fa fa-globe mr-1"></i>{{ $user->company_website }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Email Perusahaan</p>
                    <p class="mt-1 text-sm font-medium text-gray-800 dark:text-white/90">{{ $user?->company_email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Telepon Perusahaan</p>
                    <p class="mt-1 text-sm font-medium text-gray-800 dark:text-white/90">{{ $user?->company_phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Alamat Perusahaan</p>
                    <p class="mt-1 text-sm font-medium text-gray-800 dark:text-white/90">{{ $user?->company_address ?? '-' }}</p>
                </div>
            </div>

            @if($user?->company_description)
            <div class="mt-4">
                <p class="text-xs text-gray-500 dark:text-gray-400">Deskripsi Perusahaan</p>
                <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ $user->company_description }}</p>
            </div>
            @endif

            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">NPWP</p>
                    <p class="mt-1 text-sm font-medium text-gray-800 dark:text-white/90">{{ $user?->company_npwp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">SIUP</p>
                    <p class="mt-1 text-sm font-medium text-gray-800 dark:text-white/90">{{ $user?->company_siup ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">NIB</p>
                    <p class="mt-1 text-sm font-medium text-gray-800 dark:text-white/90">{{ $user?->company_nib ?? '-' }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Informasi Akun</h4>
            <dl class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs text-gray-500">Nama</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Email</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user?->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Telepon</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user?->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Bio</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user?->bio ?? '-' }}</p>
                </div>
            </dl>
        </div>

        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Pengaturan</h4>
            <dl class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs text-gray-500">Timezone</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user?->timezone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Language</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user?->language ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Theme</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user?->theme ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Notifikasi Email</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                        {{ $user?->notifications_email ? 'Aktif' : 'Nonaktif' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Notifikasi SMS</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                        {{ $user?->notifications_sms ? 'Aktif' : 'Nonaktif' }}
                    </p>
                </div>
            </dl>
        </div>
    </div>
@endsection
