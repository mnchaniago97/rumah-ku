@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">User</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola akun pengguna.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                + Tambah User
            </a>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Daftar User</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-gray-500 dark:bg-white/[0.03] dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3 font-medium">Nama</th>
                            <th class="px-6 py-3 font-medium">Email</th>
                            <th class="px-6 py-3 font-medium">Role</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    @if ($user->role === 'admin')
                                        Admin (Super Admin)
                                    @elseif ($user->role === 'agent')
                                        Agent
                                    @else
                                        User
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600 dark:bg-green-500/10 dark:text-green-400">Aktif</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-3">
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-sm font-medium text-gray-600 hover:underline dark:text-gray-300">Detail</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-sm font-medium text-brand-500 hover:underline">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium text-red-500 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
