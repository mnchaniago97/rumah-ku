<nav class="sticky top-0 z-50" x-data="{ mobileOpen: false }">
    <!-- Top Bar -->
    <div class="bg-blue-800 text-white shadow-sm">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="flex h-14 items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-extrabold tracking-tight">
                    <img src="{{ asset('assets/admin/images/logo/rumahsatu-dark.svg') }}" alt="Rumah Ku" class="h-12 w-auto">
                    </a>

                <!-- Actions (Desktop) -->
                <div class="hidden md:flex items-center gap-2">
                    <a href="{{ route('calculator') }}" class="inline-flex items-center gap-2 rounded-md bg-white px-3 py-1.5 text-sm font-semibold text-blue-800 hover:bg-white/90">
                        <i class="fa fa-calculator"></i>
                        KPR
                    </a>
                    @auth
                        <div class="relative" x-data="{ profileOpen: false }">
                            <button @click="profileOpen = !profileOpen" class="inline-flex items-center gap-2 rounded-md bg-white/10 px-3 py-1.5 text-sm font-medium text-white hover:bg-white/15">
                                <i class="fa fa-user-circle"></i>
                                {{ Auth::user()->name }}
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
                <a href="{{ route('properties') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Properti</a>
                <a href="{{ route('rumah-subsidi') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Subsidi</a>
                <a href="{{ route('sewa') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Sewa</a>
                <a href="{{ route('projects') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Perumahan Baru</a>
                <a href="{{ route('aset-lelang-bank') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Aset Bank</a>
                <a href="{{ route('agents') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Agen</a>
                <a href="{{ route('articles') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Artikel</a>
                <a href="{{ route('about') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Tentang</a>
                <a href="{{ route('contact') }}" class="block rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white" @click="mobileOpen = false">Kontak</a>
            </div>

            <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between gap-2">
                <a href="{{ route('calculator') }}" class="inline-flex items-center gap-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-blue-800 hover:bg-white/90" @click="mobileOpen = false">
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
                    <a href="{{ route('properties') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Properti</a>
                    <a href="{{ route('rumah-subsidi') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Subsidi</a>
                    <a href="{{ route('sewa') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Sewa</a>
                    <a href="{{ route('projects') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Perumahan Baru</a>
                    <a href="{{ route('aset-lelang-bank') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Aset Bank</a>
                    <a href="{{ route('agents') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Agen</a>
                    <a href="{{ route('articles') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Artikel</a>
                    <a href="{{ route('about') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Tentang</a>
                    <a href="{{ route('contact') }}" class="rounded-md px-3 py-2 text-sm font-medium hover:bg-white/10 hover:text-white">Kontak</a>
                </div>

                <div class="flex items-center gap-4 text-sm">
                    <button type="button" data-open-property-inquiry class="hover:text-white">
                        Carikan Saya Properti
                    </button>
                    <a href="{{ route('agents') }}" class="hover:text-white">Agen</a>
                </div>
            </div>
        </div>
    </div>
</nav>
