@extends('agent.layouts.app')

@section('content')
    @php
        $isDeveloper = auth()->user()?->agent_type === \App\Models\AgentApplication::TYPE_DEVELOPER;
    @endphp

    <x-common.page-breadcrumb pageTitle="Edit Profile" />

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90">Profile</h3>
        <form action="{{ route('agent.users.update', $user?->id ?? auth()->id()) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4">
                <div class="h-16 w-16 overflow-hidden rounded-full bg-gray-200">
                    <img src="{{ $user?->avatar ?? '/assets/admin/images/user/owner.png' }}" alt="avatar" class="h-full w-full object-cover">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Avatar</label>
                    <input type="file" name="avatar" accept="image/*"
                        class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                    <input name="name" value="{{ old('name', $user?->name) }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input name="email" type="email" value="{{ old('email', $user?->email) }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon</label>
                    <input name="phone" value="{{ old('phone', $user?->phone) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                    <textarea name="bio" rows="4"
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('bio', $user?->bio) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan
                </button>
                <a href="{{ route('agent.users.show', auth()->id()) }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>

    @if($isDeveloper)
    <!-- Developer Company Profile Section -->
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90">Data Perusahaan Developer</h3>
        <form action="{{ route('agent.profile.company.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4">
                <div class="h-20 w-20 overflow-hidden rounded-lg bg-gray-200 flex items-center justify-center">
                    @if($user?->company_logo)
                        <img src="{{ $user->company_logo }}" alt="Company Logo" class="h-full w-full object-cover">
                    @else
                        <i class="fa fa-building text-gray-400 text-2xl"></i>
                    @endif
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Logo Perusahaan</label>
                    <input type="file" name="company_logo" accept="image/*"
                        class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Perusahaan <span class="text-red-500">*</span></label>
                    <input name="company_name" value="{{ old('company_name', $user?->company_name) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email Perusahaan</label>
                    <input name="company_email" type="email" value="{{ old('company_email', $user?->company_email) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Telepon Perusahaan</label>
                    <input name="company_phone" value="{{ old('company_phone', $user?->company_phone) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Website Perusahaan</label>
                    <input name="company_website" type="url" value="{{ old('company_website', $user?->company_website) }}" placeholder="https://"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Perusahaan</label>
                    <textarea name="company_address" rows="2"
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('company_address', $user?->company_address) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Perusahaan</label>
                    <textarea name="company_description" rows="4"
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('company_description', $user?->company_description) }}</textarea>
                </div>
            </div>

            <!-- Legal Documents Section -->
            <h4 class="mt-6 mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Dokumen Legal</h4>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">NPWP Perusahaan</label>
                    <input name="company_npwp" value="{{ old('company_npwp', $user?->company_npwp) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">SIUP</label>
                    <input name="company_siup" value="{{ old('company_siup', $user?->company_siup) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">NIB</label>
                    <input name="company_nib" value="{{ old('company_nib', $user?->company_nib) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan Data Perusahaan
                </button>
            </div>
        </form>
    </div>
    @endif
@endsection

