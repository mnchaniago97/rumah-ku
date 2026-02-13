@extends('admin.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="User Profile" />

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">Profile</h3>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="h-14 w-14 overflow-hidden rounded-full bg-gray-200">
                        <img src="{{ $user?->avatar ?? '/assets/admin/images/user/owner.png' }}" alt="avatar"
                            class="h-full w-full object-cover">
                    </div>
                    <div>
                        <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">
                            {{ $user?->name ?? 'Guest' }}
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $user?->bio ?? 'Team Member' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.profile.edit') }}"
                        class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300">
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                <div class="flex items-center justify-between">
                    <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Personal Information</h4>
                    <a href="{{ route('admin.profile.edit') }}"
                        class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300">
                        Edit
                    </a>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
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
                        <p class="text-xs text-gray-500">Language</p>
                        <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user?->language ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                <div class="flex items-center justify-between">
                    <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Settings</h4>
                    <a href="{{ route('admin.profile.settings') }}"
                        class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300">
                        Edit
                    </a>
                </div>

                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs text-gray-500">Timezone</p>
                        <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user?->timezone ?? '-' }}</p>
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
                </div>
            </div>
        </div>
    </div>
@endsection
