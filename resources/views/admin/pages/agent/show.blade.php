@extends('admin.layouts.app')

@section('content')
    @php
        $typeOptions = \App\Models\AgentApplication::typeOptions();
    @endphp

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Agent Detail</h1>
            <a href="{{ route('admin.agents.index') }}"
                class="text-sm text-gray-600 hover:underline dark:text-gray-300">Kembali</a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-500/10 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

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
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Verifikasi</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                        @if(!empty($agent->agent_verified_at))
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                                <i class="fa fa-circle-check"></i>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-600 dark:bg-white/[0.06] dark:text-gray-300">
                                <i class="fa fa-circle-xmark"></i>
                                Belum verified
                            </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Tipe</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $typeOptions[$agent->agent_type] ?? ($agent->agent_type ?? '-') }}
                    </dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Bio</dt>
                    <dd class="text-sm text-gray-700 dark:text-gray-300">{{ $agent->bio ?? '-' }}</dd>
                </div>
            </div>

            @if((auth()->user()->role ?? null) === 'admin')
                <div class="mb-6 rounded-xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/30">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">Kelola Tipe & Status</div>
                    <form method="POST" action="{{ route('admin.agents.type', $agent) }}" class="mt-4 grid gap-4 md:grid-cols-3">
                        @csrf
                        @method('PATCH')

                        <div class="md:col-span-2">
                            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Tipe Agent</label>
                            <select name="agent_type" class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                                <option value="">-</option>
                                @foreach($typeOptions as $k => $label)
                                    <option value="{{ $k }}" @selected($agent->agent_type === $k)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Status</label>
                            <select name="is_active" class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                                <option value="1" @selected((bool)$agent->is_active === true)>Aktif</option>
                                <option value="0" @selected((bool)$agent->is_active === false)>Nonaktif</option>
                            </select>
                        </div>

                        <div class="md:col-span-3">
                            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-600">
                                Simpan
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        @if(empty($agent->agent_verified_at))
                            <form method="POST" action="{{ route('admin.agents.verify', $agent) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">
                                    <i class="fa fa-circle-check"></i>
                                    Verifikasi Agent
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.agents.unverify', $agent) }}" onsubmit="return confirm('Batalkan status verified untuk agent ini?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-gray-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800">
                                    <i class="fa fa-circle-xmark"></i>
                                    Batalkan Verifikasi
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

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
