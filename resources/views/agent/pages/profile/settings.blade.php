@extends('agent.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Profile Settings" />

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90">Settings</h3>
        <form action="{{ route('agent.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Timezone</label>
                    <input name="timezone" value="{{ old('timezone', $user?->timezone) }}" placeholder="Asia/Jakarta"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Language</label>
                    <select name="language"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="id" @selected(old('language', $user?->language) === 'id')>Bahasa Indonesia</option>
                        <option value="en" @selected(old('language', $user?->language) === 'en')>English</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Theme</label>
                    <select name="theme"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">
                        <option value="">System</option>
                        <option value="light" @selected(old('theme', $user?->theme) === 'light')>Light</option>
                        <option value="dark" @selected(old('theme', $user?->theme) === 'dark')>Dark</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="notifications_email" value="1" class="h-4 w-4 rounded border-gray-300"
                        @checked(old('notifications_email', $user?->notifications_email)) />
                    Notifikasi email
                </label>
                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="notifications_sms" value="1" class="h-4 w-4 rounded border-gray-300"
                        @checked(old('notifications_sms', $user?->notifications_sms)) />
                    Notifikasi SMS
                </label>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan
                </button>
                <a href="{{ route('agent.profile') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>
@endsection

