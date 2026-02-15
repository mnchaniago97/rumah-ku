@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Profile</h1>
            <a href="{{ route('agent.users.show', $user) }}" 
               class="text-sm text-gray-600 hover:underline dark:text-gray-300">
                ← Back to Profile
            </a>
        </div>

        <form action="{{ route('agent.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Information -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-5">Profile Information</h3>
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-20 w-20 overflow-hidden rounded-full bg-gray-200">
                        <img src="{{ $user->avatar ?? '/assets/admin/images/user/owner.png' }}" alt="avatar" class="h-full w-full object-cover">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Avatar</label>
                        <input type="file" name="avatar" accept="image/*"
                            class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                        <input name="name" value="{{ old('name', $user->name) }}" required
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input name="email" type="email" value="{{ old('email', $user->email) }}" required
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                        <textarea name="bio" rows="3"
                            class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] mt-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-5">Personal Information</h3>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama lengkap (sesuai KTP)</label>
                        <input name="ktp_full_name" value="{{ old('ktp_full_name', $user->ktp_full_name) }}"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                        <input name="phone" value="{{ old('phone', $user->phone) }}"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor HP / WhatsApp aktif</label>
                        <input name="whatsapp_phone" value="{{ old('whatsapp_phone', $user->whatsapp_phone) }}" placeholder="62xxxxxxxxxx"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email profesional</label>
                        <input name="professional_email" type="email" value="{{ old('professional_email', $user->professional_email) }}"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Domisili / area kerja</label>
                        <input name="domicile_area" value="{{ old('domicile_area', $user->domicile_area) }}" placeholder="Misal: Jakarta Barat, BSD, dll"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] mt-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-5">Professional Information</h3>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama kantor / brand agen</label>
                        <input name="agency_brand" value="{{ old('agency_brand', $user->agency_brand) }}"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Jabatan</label>
                        <input name="job_title" value="{{ old('job_title', $user->job_title) }}" placeholder="Marketing / Property Consultant / Broker"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor registrasi agen (jika ada)</label>
                        <input name="agent_registration_number" value="{{ old('agent_registration_number', $user->agent_registration_number) }}"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Pengalaman (tahun)</label>
                        <input name="experience_years" type="number" min="0" max="80" value="{{ old('experience_years', $user->experience_years) }}"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Spesialis area</label>
                        <input name="specialization_areas" value="{{ old('specialization_areas', $user->specialization_areas) }}" placeholder="Misal: Jakarta Barat, BSD, dll"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] mt-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-5">Account Settings</h3>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Timezone</label>
                        <input name="timezone" value="{{ old('timezone', $user->timezone) }}" placeholder="Asia/Jakarta"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Language</label>
                        <select name="language"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">
                            <option value="">-</option>
                            <option value="id" @selected(old('language', $user->language) === 'id')>Bahasa Indonesia</option>
                            <option value="en" @selected(old('language', $user->language) === 'en')>English</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Theme</label>
                        <select name="theme"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">
                            <option value="">System</option>
                            <option value="light" @selected(old('theme', $user->theme) === 'light')>Light</option>
                            <option value="dark" @selected(old('theme', $user->theme) === 'dark')>Dark</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Password (opsional)</label>
                        <input name="password" type="password" placeholder="Kosongkan jika tidak diubah"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    </div>
                    <div class="md:col-span-2 space-y-3">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="notifications_email" value="1" class="h-4 w-4 rounded border-gray-300"
                                @checked(old('notifications_email', $user->notifications_email)) />
                            Notifikasi email
                        </label>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" name="notifications_sms" value="1" class="h-4 w-4 rounded border-gray-300"
                                @checked(old('notifications_sms', $user->notifications_sms)) />
                            Notifikasi SMS
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan
                </button>
                <a href="{{ route('agent.users.show', $user) }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>
@endsection
