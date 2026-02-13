@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">User Detail</h1>
            <a href="{{ route('agent.users.index') }}"
                class="text-sm text-gray-600 hover:underline dark:text-gray-300">Kembali</a>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
            <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90">Profile</h3>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 overflow-hidden rounded-full bg-gray-200">
                            <img src="{{ $user->avatar ?? '/assets/admin/images/user/owner.png' }}" alt="avatar"
                                class="h-full w-full object-cover">
                        </div>
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">
                                {{ $user->name }}
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->bio ?? 'Team Member' }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                {{ $user->role === 'admin' ? 'Admin (Super Admin)' : 'Agent' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Personal Information</h4>
                    </div>

                    <form class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2"
                        action="{{ route('agent.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="sm:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Avatar</label>
                            <input type="file" name="avatar" accept="image/*"
                                class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                        </div>
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
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                            <input name="phone" value="{{ old('phone', $user->phone) }}"
                                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                            <textarea name="bio" rows="3"
                                class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                        <div class="sm:col-span-2 flex items-center gap-3">
                            <button type="submit"
                                class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Settings</h4>
                    </div>

                    <form class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2"
                        action="{{ route('agent.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                        <div class="sm:col-span-2 space-y-3">
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
                        <div class="sm:col-span-2 flex items-center gap-3">
                            <button type="submit"
                                class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

