@extends('admin.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Profil Saya" />

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Profil Saya</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola informasi akun dan pengaturan Anda.</p>
            </div>
            <a href="{{ route('admin.users.show', auth()->id()) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                Edit Profil
            </a>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Identitas Dasar</h4>
                <dl class="mt-5 space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Nama lengkap</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->email ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">No. Telepon</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->phone ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Role</dt>
                        <dd class="text-right">
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-200">
                                {{ ucfirst($user?->role ?? 'admin') }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Informasi Tambahan</h4>
                <dl class="mt-5 space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Bio</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->bio ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Timezone</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->timezone ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Language</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->language ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-gray-500 dark:text-gray-400">Theme</dt>
                        <dd class="text-gray-900 dark:text-white text-right">{{ $user?->theme ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Pengaturan Notifikasi</h4>
            <dl class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
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

        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Informasi Akun</h4>
            <dl class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs text-gray-500">Terakhir login</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                        {{ $user?->last_login_at ? $user->last_login_at->format('d M Y H:i') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Akun dibuat</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">
                        {{ $user?->created_at ? $user->created_at->format('d M Y H:i') : '-' }}
                    </p>
                </div>
            </dl>
        </div>
    </div>
@endsection
