@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">User</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Akun saya.</p>
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
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Agent</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600 dark:bg-green-500/10 dark:text-green-400">Aktif</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('agent.users.show', $user) }}" class="text-sm font-medium text-gray-600 hover:underline dark:text-gray-300">Detail</a>
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

