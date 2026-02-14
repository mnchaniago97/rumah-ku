<nav class="sticky top-0 z-50" x-data="{ mobileOpen: false }">
    <!-- Top Bar -->
    <div class="bg-blue-800 text-white shadow-sm">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="flex h-14 items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-extrabold tracking-tight">
                    <img src="{{ asset('assets/admin/images/logo/rumahio-dark.svg') }}" alt="Rumah IO" class="h-9 w-auto">
                </a>

                <!-- Actions (Desktop) -->
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('kpr') }}" class="inline-flex items-center gap-2 rounded-md bg-white px-3 py-1.5 text-sm font-semibold text-blue-800 hover:bg-white/90">
                        <i class="fa fa-calculator"></i>
                        KPR
                    </a>
                    @auth
                        <div class="relative" x-data="{ profileOpen: false }">
                            <button @click="profileOpen = !profileOpen" class="inline-flex items-center gap-2 rounded-md bg-white/10 px-3 py-1.5 text-sm font-medium text-white hover:bg-white/15">
                                <i class="fa fa-user-circle"></i>
                                {{ str_replace(['Rumah Ku', 'Rumahku', 'RumahKu'], 'Rumah IO', Auth::user()->name) }}
                                <i class="fa fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="profileOpen" @click.outside="profileOpen = false" class="absolute right-0 mt-2 w-48 rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5" x-cloak x-transition>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fa fa-cog w-4"></i> Dashboard
                                    </a>
                                @elseif(Auth::user()->role === 'agent')
                                    <a href="{{ route('agent.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fa fa-cog w-4"></i> Dashboard
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100">
                                        <i class="fa fa-sign-out-alt w-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-md px-2 py-1.5 text-sm font-medium text-white/90 hover:text-white">
                            <i class="fa fa-user"></i>
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center rounded-md border border-white/40 bg-white/10 px-3 py-1.5 text-sm font-semibold text-white hover:bg-white/15">
                            Daftar
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex md:hidden">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-md bg-white/10 p-2 text-white/90 hover:bg-white/15"
                        aria-label="Buka menu"
                        aria-controls="mobile-menu"
                        :aria-expanded="mobileOpen"
                        @click="mobileOpen = !mobileOpen"
                    >
                        <i class="fa fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden bg-blue-800 text-white border-t border-white/10" x-cloak x-show="mobileOpen" x-transition>
        <div class="max-w-[1200px] mx-auto px-4 py-3" id="mobile-menu" @click.outside="mobileOpen = false">
            <div class="space-y-1">
                <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Beranda</a>

                <div class="rounded-md" x-data="{ open: false }">
                    <button type="button" class="flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white"
                        @click="open = !open" :aria-expanded="open">
                        <span>Properti</span>
                        <i class="fa fa-chevron-down text-xs transition" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition class="mt-1 space-y-1 pl-2" x-cloak>
                        <a href="{{ route('properties') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Dijual</a>
                        <a href="{{ route('sewa') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Disewa</a>
                        <a href="{{ route('projects') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Properti Baru</a>
                        <a href="{{ route('aset-lelang-bank') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Aset Bank</a>
                        <a href="{{ route('rumah-subsidi') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Rumah Subsidi</a>
                    </div>
                </div>

                <a href="{{ route('agents') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Agen</a>

                    <div class="rounded-md" x-data="{ open: false }">
                    <button type="button" class="flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white"
                        @click="open = !open" :aria-expanded="open">
                        <span>Lainnya</span>
                        <i class="fa fa-chevron-down text-xs transition" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition class="mt-1 space-y-1 pl-2" x-cloak>
                        <a href="{{ route('articles') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">
                            <i class="fa fa-newspaper w-4 text-white/80"></i>
                            Artikel
                        </a>
                        <a href="{{ route('forum') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">
                            <i class="fa fa-comments w-4 text-white/80"></i>
                            Forum
                        </a>
                        <a href="{{ route('calculator') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">
                            <i class="fa fa-calculator w-4 text-white/80"></i>
                            Kalkulator
                        </a>
                        <a href="{{ route('about') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">
                            <i class="fa fa-info-circle w-4 text-white/80"></i>
                            Tentang
                        </a>
                        <a href="{{ route('contact') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/10 hover:text-white" @click="mobileOpen = false">
                            <i class="fa fa-envelope w-4 text-white/80"></i>
                            Kontak
                        </a>
                    </div>
                </div>

                <div class="rounded-md bg-white/5 p-2" x-data="{ open: false }">
                    <button type="button" class="flex w-full items-center justify-between rounded-md px-2 py-2 text-sm font-semibold hover:bg-white/10 hover:text-white"
                        @click="open = !open" :aria-expanded="open">
                        <span class="inline-flex items-center gap-2">
                            <i class="fa fa-bullhorn"></i>
                            Pasang Iklan
                        </span>
                        <i class="fa fa-chevron-down text-xs transition" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition class="mt-1 space-y-1" x-cloak>
                        <a href="{{ route('pricing.show', ['type' => 'property-owner']) }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-semibold bg-white/10 hover:bg-white/15 hover:text-white" @click="mobileOpen = false">
                            <i class="fa fa-bullhorn w-4 text-white/80"></i>
                            Iklankan Sekarang
                        </a>
                        <a href="{{ route('pricing.show', ['type' => 'property-agent']) }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-semibold bg-white/10 hover:bg-white/15 hover:text-white" @click="mobileOpen = false">
                            <i class="fa fa-user-tie w-4 text-white/80"></i>
                            Daftar Jadi Agen
                        </a>
                        <a href="{{ route('pricing.show', ['type' => 'in-house-marketing']) }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-semibold bg-white/10 hover:bg-white/15 hover:text-white" @click="mobileOpen = false">
                            <i class="fa fa-briefcase w-4 text-white/80"></i>
                            In-House Marketing
                        </a>
                        <a href="{{ route('pricing.show', ['type' => 'developer']) }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-semibold bg-white/10 hover:bg-white/15 hover:text-white" @click="mobileOpen = false">
                            <i class="fa fa-city w-4 text-white/80"></i>
                            Developer
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between gap-2">
                <a href="{{ route('kpr') }}" class="inline-flex items-center gap-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-blue-800 hover:bg-white/90" @click="mobileOpen = false">
                    <i class="fa fa-calculator"></i>
                    KPR
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-md px-2 py-2 text-sm font-medium text-white/90 hover:text-white" @click="mobileOpen = false">
                        <i class="fa fa-user"></i>
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center rounded-md border border-white/40 bg-white/10 px-3 py-2 text-sm font-semibold text-white hover:bg-white/15" @click="mobileOpen = false">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar (Desktop Menu) -->
    <div class="hidden md:block bg-blue-700/95 text-white/90 border-t border-white/10">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="flex h-11 items-center justify-between">
                <div class="flex items-center gap-1">
                    <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Beranda</a>

                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button type="button"
                            class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white"
                            @click="open = !open" :aria-expanded="open">
                            Properti
                            <i class="fa fa-chevron-down text-[10px] opacity-90"></i>
                        </button>
                        <div x-show="open" x-transition x-cloak
                            class="absolute left-0 mt-2 w-64 overflow-hidden rounded-xl bg-white text-gray-800 shadow-xl ring-1 ring-black/5">
                            <div class="p-2">
                                <a href="{{ route('properties') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-700"><i class="fa fa-home"></i></span>
                                    Dijual
                                </a>
                                <a href="{{ route('sewa') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 text-indigo-700"><i class="fa fa-key"></i></span>
                                    Disewa
                                </a>
                                <a href="{{ route('projects') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700"><i class="fa fa-building"></i></span>
                                    Properti Baru
                                </a>
                                <a href="{{ route('aset-lelang-bank') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-amber-50 text-amber-700"><i class="fa fa-landmark"></i></span>
                                    Aset Bank
                                </a>
                                <a href="{{ route('rumah-subsidi') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-sky-50 text-sky-700"><i class="fa fa-tags"></i></span>
                                    Rumah Subsidi
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('agents') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Agen</a>

                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button type="button"
                            class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white"
                            @click="open = !open" :aria-expanded="open">
                            Lainnya
                            <i class="fa fa-chevron-down text-[10px] opacity-90"></i>
                        </button>
                        <div x-show="open" x-transition x-cloak
                            class="absolute left-0 mt-2 w-60 overflow-hidden rounded-xl bg-white text-gray-800 shadow-xl ring-1 ring-black/5">
                            <div class="p-2">
                                <a href="{{ route('articles') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-violet-50 text-violet-700"><i class="fa fa-newspaper"></i></span>
                                    Artikel
                                </a>
                                <a href="{{ route('forum') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-fuchsia-50 text-fuchsia-700"><i class="fa fa-comments"></i></span>
                                    Forum
                                </a>
                                <a href="{{ route('calculator') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-700"><i class="fa fa-calculator"></i></span>
                                    Kalkulator
                                </a>
                                <a href="{{ route('about') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-slate-50 text-slate-700"><i class="fa fa-info-circle"></i></span>
                                    Tentang
                                </a>
                                <a href="{{ route('contact') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700"><i class="fa fa-envelope"></i></span>
                                    Kontak
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 text-sm">
                    <button type="button" data-open-property-inquiry class="hover:text-white">
                        Carikan Saya Properti
                    </button>

                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button type="button"
                            class="inline-flex items-center gap-2 rounded-md bg-white/10 px-3 py-2 font-semibold text-white hover:bg-white/15"
                            @click="open = !open" @click.outside="open = false" :aria-expanded="open">
                            <i class="fa fa-bullhorn"></i>
                            Pasang Iklan
                            <i class="fa fa-chevron-down text-[10px] opacity-90"></i>
                        </button>
                        <div x-show="open" x-transition x-cloak
                            class="absolute right-0 mt-2 w-64 overflow-hidden rounded-xl bg-white text-gray-800 shadow-xl ring-1 ring-black/5">
                            <div class="p-2">
                                <a href="{{ route('pricing.show', ['type' => 'property-owner']) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-amber-50 text-amber-700"><i class="fa fa-bullhorn"></i></span>
                                    Iklankan Sekarang
                                </a>
                                <a href="{{ route('pricing.show', ['type' => 'property-agent']) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-700"><i class="fa fa-user-tie"></i></span>
                                    Daftar Jadi Agen
                                </a>
                                <a href="{{ route('pricing.show', ['type' => 'in-house-marketing']) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700"><i class="fa fa-briefcase"></i></span>
                                    In-House Marketing
                                </a>
                                <a href="{{ route('pricing.show', ['type' => 'developer']) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold hover:bg-gray-50">
                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-50 text-indigo-700"><i class="fa fa-city"></i></span>
                                    Developer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
