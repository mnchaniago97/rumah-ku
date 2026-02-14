@php
    $layout = request()->is('admin*')
        ? 'admin.layouts.fullscreen-layout'
        : (request()->is('agent*') ? 'agent.layouts.fullscreen-layout' : 'frontend.layouts.app');

    $isDashboard = request()->is('admin*') || request()->is('agent*');
    $homeUrl = $isDashboard
        ? (request()->is('admin*') ? route('admin.dashboard') : route('agent.dashboard'))
        : route('home');

    $title = $title ?? 'Halaman Tidak Ditemukan';
@endphp

@extends($layout)

@section('content')
    @if($isDashboard)
        <div class="min-h-screen flex items-center justify-center px-6 py-12 bg-gray-50 dark:bg-gray-900">
            <div class="w-full max-w-xl rounded-2xl border border-gray-200 bg-white p-8 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Error 404</div>
                        <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">Halaman tidak ditemukan</h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Link yang kamu buka tidak tersedia atau sudah dipindahkan.
                        </p>
                    </div>
                    <div class="hidden sm:flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-200">
                        <span class="text-2xl font-extrabold">404</span>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ $homeUrl }}"
                        class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-600">
                        Kembali ke Dashboard
                    </a>
                    <button type="button" onclick="history.back()"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/[0.03]">
                        Kembali (Back)
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gray-50">
            <div class="max-w-[1200px] mx-auto px-4 py-16">
                <div class="rounded-3xl bg-white border border-gray-200 p-10 shadow-sm">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
                        <div>
                            <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                <span>Error</span>
                                <span class="h-1 w-1 rounded-full bg-blue-600"></span>
                                <span>404</span>
                            </div>
                            <h1 class="mt-4 text-3xl md:text-4xl font-extrabold text-gray-900">
                                Halaman tidak ditemukan
                            </h1>
                            <p class="mt-3 text-gray-600">
                                Maaf, halaman yang kamu cari tidak tersedia atau sudah dipindahkan.
                            </p>

                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="{{ route('home') }}"
                                    class="inline-flex items-center justify-center rounded-xl bg-blue-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">
                                    Ke Beranda
                                </a>
                                <a href="{{ route('properties') }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Cari Properti
                                </a>
                                <a href="{{ route('sewa') }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Lihat Sewa
                                </a>
                                <button type="button" onclick="history.back()"
                                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Kembali (Back)
                                </button>
                            </div>
                        </div>

                        <div class="w-full md:w-auto">
                            <div class="rounded-3xl bg-gradient-to-br from-blue-700 to-indigo-600 p-8 text-white">
                                <div class="text-6xl font-extrabold leading-none">404</div>
                                <div class="mt-2 text-sm text-white/90">
                                    Tips: cek kembali URL atau gunakan menu di atas.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

