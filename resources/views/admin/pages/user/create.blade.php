@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create User</h1>

        <form action="{{ route('admin.users.store') }}" method="POST"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            @csrf

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                    <input name="name" value="{{ old('name') }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input name="email" type="email" value="{{ old('email') }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                    <select name="role" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">
                        <option value="admin" @selected(old('role') === 'admin')>Admin (Super Admin)</option>
                        <option value="agent" @selected(old('role', 'agent') === 'agent')>Agent</option>
                        <option value="user" @selected(old('role') === 'user')>User</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input name="password" type="password" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan
                </button>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>
@endsection
