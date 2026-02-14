<section class="bg-gray-50 py-6">
    <div class="max-w-[1200px] mx-auto px-4">
        <div class="grid grid-cols-2 gap-3 md:grid-cols-4 lg:grid-cols-8">
            <button type="button" data-open-property-inquiry class="flex flex-col items-center rounded-lg bg-white p-3 shadow-sm transition hover:shadow-md group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                    <i class="fa fa-search text-lg"></i>
                </div>
                <span class="mt-1.5 text-xs font-medium text-gray-700 text-center group-hover:text-blue-600">Carikan Properti</span>
            </button>
            <a href="{{ route('advertise') }}" class="flex flex-col items-center rounded-lg bg-white p-3 shadow-sm transition hover:shadow-md group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                    <i class="fa fa-bullhorn text-lg"></i>
                </div>
                <span class="mt-1.5 text-xs font-medium text-gray-700 text-center group-hover:text-green-600">Iklankan Properti</span>
            </a>
            <a href="{{ route('agents') }}" class="flex flex-col items-center rounded-lg bg-white p-3 shadow-sm transition hover:shadow-md group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition">
                    <i class="fa fa-user text-lg"></i>
                </div>
                <span class="mt-1.5 text-xs font-medium text-gray-700 text-center group-hover:text-purple-600">Cari Agen</span>
            </a>
            <a href="{{ route('discounted') }}" class="flex flex-col items-center rounded-lg bg-white p-3 shadow-sm transition hover:shadow-md group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white transition">
                    <i class="fa fa-arrow-down text-lg"></i>
                </div>
                <span class="mt-1.5 text-xs font-medium text-gray-700 text-center group-hover:text-red-600">Turun Harga</span>
            </a>
            <a href="{{ route('kpr.simulasi') }}" class="flex flex-col items-center rounded-lg bg-white p-3 shadow-sm transition hover:shadow-md group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100 text-yellow-600 group-hover:bg-yellow-600 group-hover:text-white transition">
                    <i class="fa fa-calculator text-lg"></i>
                </div>
                <span class="mt-1.5 text-xs font-medium text-gray-700 text-center group-hover:text-yellow-600">Kalkulator KPR</span>
            </a>
            <a href="{{ route('kpr.pindah') }}" class="flex flex-col items-center rounded-lg bg-white p-3 shadow-sm transition hover:shadow-md group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                    <i class="fa fa-exchange text-lg"></i>
                </div>
                <span class="mt-1.5 text-xs font-medium text-gray-700 text-center group-hover:text-indigo-600">Pindah KPR</span>
            </a>
            <a href="{{ route('forum') }}" class="flex flex-col items-center rounded-lg bg-white p-3 shadow-sm transition hover:shadow-md group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-pink-100 text-pink-600 group-hover:bg-pink-600 group-hover:text-white transition">
                    <i class="fa fa-comments text-lg"></i>
                </div>
                <span class="mt-1.5 text-xs font-medium text-gray-700 text-center group-hover:text-pink-600">Tanya Forum</span>
            </a>
            <a href="{{ route('more') }}" class="flex flex-col items-center rounded-lg bg-white p-3 shadow-sm transition hover:shadow-md group">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-600 group-hover:bg-gray-600 group-hover:text-white transition">
                    <i class="fa fa-ellipsis-h text-lg"></i>
                </div>
                <span class="mt-1.5 text-xs font-medium text-gray-700 text-center group-hover:text-gray-600">Lainnya</span>
            </a>
        </div>
    </div>
</section>
