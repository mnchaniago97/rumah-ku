@extends('admin.layouts.fullscreen-layout')

@section('content')
    <div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900">
        <div class="relative flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-gray-900">
            <!-- Form -->
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto w-full max-w-md pt-10">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg class="stroke-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Kembali ke Login
                    </a>
                </div>

                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                    <div class="mb-5 sm:mb-8">
                        <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white/90">
                            Reset Password
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Masukkan email Anda. Kami akan kirim link untuk membuat password baru.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        @if (session('success'))
                            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                <p class="font-medium">Gagal mengirim link reset.</p>
                                <ul class="mt-1 list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-5">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-3 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
                            </div>

                            <button type="submit"
                                class="bg-brand-500 hover:bg-brand-600 inline-flex w-full items-center justify-center rounded-lg px-5 py-3 text-sm font-semibold text-white transition-colors">
                                Kirim Link Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right panel -->
            <div class="bg-brand-950 relative hidden h-full w-full items-center lg:grid lg:w-1/2 dark:bg-white/5">
                <div class="z-1 flex items-center justify-center">
                    <x-common.common-grid-shape/>
                    <div class="flex max-w-xs flex-col items-center">
                        <a href="/" class="mb-4 inline-flex">
                            <img src="/assets/admin/images/logo/rumahio-dark.svg" alt="Rumah IO" class="h-30 w-auto" />
                        </a>
                        <p class="text-center text-gray-400 dark:text-white/60">
                            “Cari. Temukan. Punya Rumah.”
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
