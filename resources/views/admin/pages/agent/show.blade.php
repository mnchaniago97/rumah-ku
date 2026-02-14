@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Agent Detail</h1>
            <a href="{{ route('admin.agents.index') }}"
                class="text-sm text-gray-600 hover:underline dark:text-gray-300">Kembali</a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Nama</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Telepon</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Status</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $agent->is_active ? 'Aktif' : 'Menunggu' }}
                    </dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Bio</dt>
                    <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $agent->bio ?? '-' }}</dd>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">🪪 Identitas Dasar</h3>
                    <dl class="mt-3 grid grid-cols-1 gap-3">
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Nama lengkap (sesuai KTP)</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->ktp_full_name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Nomor HP / WhatsApp aktif</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->whatsapp_phone ?? ($agent->phone ?? '-') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Email profesional</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->professional_email ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Domisili / area kerja</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->domicile_area ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Foto profil formal</dt>
                            <dd class="mt-2">
                                <div class="h-16 w-16 overflow-hidden rounded-full bg-gray-200">
                                    <img src="{{ $agent->avatar ?? '/assets/admin/images/user/owner.png' }}" alt="avatar" class="h-full w-full object-cover">
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">🧑‍💼 Identitas Profesi</h3>
                    <dl class="mt-3 grid grid-cols-1 gap-3">
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Nama kantor / brand agen</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->agency_brand ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Jabatan</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->job_title ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Nomor registrasi agen</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->agent_registration_number ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Pengalaman</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ filled($agent->experience_years) ? ($agent->experience_years . ' tahun') : '-' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">Spesialis area</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $agent->specialization_areas ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
