<section class="relative z-30 -mt-60 md:mt-0 pb-2 -mb-8 md:-mb-20">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="relative mx-auto w-full -translate-y-[30%] text-center md:w-7/12 md:-translate-y-1/2 rounded-xl bg-blue-600/90 px-4 py-6 text-white">
            <h1 class="text-xl md:text-2xl font-bold">
                Temukan Rumah Impian Anda
            </h1>
            <p class="mx-auto mt-1 max-w-xl text-sm text-blue-100">
                Koleksi properti terbaik dengan harga terjangkau
            </p>

            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="mx-auto mt-4">
                <div class="flex flex-col gap-2 rounded-lg bg-white/95 p-2 shadow-lg sm:flex-row">
                    <div class="flex-1">
                        <input type="text" name="q" placeholder="Cari properti..."
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="w-full sm:w-32">
                        <select name="type" class="w-full rounded-md border border-gray-300 px-2 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tipe</option>
                            <option value="Rumah">Rumah</option>
                            <option value="Apartemen">Apartemen</option>
                            <option value="Villa">Villa</option>
                            <option value="Ruko">Ruko</option>
                            <option value="Tanah">Tanah</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-32">
                        <select name="status" class="w-full rounded-md border border-gray-300 px-2 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Status</option>
                            <option value="dijual">Dijual</option>
                            <option value="disewakan">Disewakan</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 sm:w-auto">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Shortcut Menu -->
@include('frontend.components.shortcut-menu')
