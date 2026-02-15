@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">My Profile</h1>
            <a href="{{ route('agent.users.edit', $user) }}" 
               class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Profile
            </a>
        </div>

        <!-- Profile Card -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center gap-6">
                <div class="h-24 w-24 overflow-hidden rounded-full bg-gray-200">
                    <img src="{{ $user->avatar ?? '/assets/admin/images/user/owner.png' }}" alt="avatar" class="h-full w-full object-cover">
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $user->name }}</h4>
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->bio ?? 'No bio yet' }}</p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $user->role === 'admin' ? 'Admin' : 'Agent' }}
                        @if($user->agent_verified_at)
                            <span class="inline-flex items-center gap-1 ml-2 text-emerald-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Verified
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Personal Information -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-5">Personal Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nama Lengkap (KTP)</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->ktp_full_name ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->email ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Telepon</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->phone ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">WhatsApp</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->whatsapp_phone ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email Profesional</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->professional_email ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Domisili / Area Kerja</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->domicile_area ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-5">Professional Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Kantor / Brand</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->agency_brand ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Jabatan</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->job_title ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nomor Registrasi</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->agent_registration_number ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Pengalaman</label>
                    <p class="text-gray-800 dark:text-white">
                        {{ $user->experience_years ? $user->experience_years . ' tahun' : '-' }}
                    </p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Spesialis Area</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->specialization_areas ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Account Settings Summary -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-5">Account Settings</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Timezone</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->timezone ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Language</label>
                    <p class="text-gray-800 dark:text-white">
                        @if($user->language === 'id')
                            Bahasa Indonesia
                        @elseif($user->language === 'en')
                            English
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Theme</label>
                    <p class="text-gray-800 dark:text-white">
                        @if($user->theme === 'light')
                            Light
                        @elseif($user->theme === 'dark')
                            Dark
                        @else
                            System
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email Notifications</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->notifications_email ? 'Enabled' : 'Disabled' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">SMS Notifications</label>
                    <p class="text-gray-800 dark:text-white">{{ $user->notifications_sms ? 'Enabled' : 'Disabled' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
