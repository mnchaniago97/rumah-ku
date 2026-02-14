@extends('frontend.layouts.app')

@section('content')
    @php
        $fallbackImages = collect([
            '/assets/admin/images/product/product-01.jpg',
            '/assets/admin/images/product/product-02.jpg',
            '/assets/admin/images/product/product-03.jpg',
            '/assets/admin/images/product/product-04.jpg',
        ]);

        $normalizeImage = function (?string $path) {
            if (blank($path)) {
                return null;
            }
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
                return $path;
            }
            return '/storage/' . ltrim($path, '/');
        };

        $formatRupiah = function ($value) {
            if (!filled($value) || !is_numeric($value)) {
                return 'Hubungi Kami';
            }
            return 'Rp ' . number_format((float) $value, 0, ',', '.');
        };
    @endphp

    <div class="bg-gray-50">
        {{-- Hero --}}
        <div class="relative overflow-hidden">
            <div class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-700">
                <div class="mx-auto max-w-[1200px] px-4 pt-14 pb-20">
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12 lg:items-center">
                        <div class="lg:col-span-6">
                            <h1 class="text-3xl font-extrabold tracking-tight text-white">Aset Lelang Bank</h1>
                            <p class="mt-2 max-w-xl text-sm text-white/90">
                                Dapatkan properti lelang bank dengan harga terjangkau hanya di Rumah IO.
                            </p>
                        </div>
                        <div class="lg:col-span-6">
                            <form action="{{ route('aset-lelang-bank') }}" method="GET"
                                class="rounded-2xl bg-white/95 p-4 shadow-sm ring-1 ring-black/5 backdrop-blur">
                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-12">
                                    <div class="sm:col-span-7">
                                        <label class="sr-only">Cari</label>
                                        <div class="relative">
                                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                                                <i class="fa fa-magnifying-glass"></i>
                                            </span>
                                            <input name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari lokasi / judul properti..."
                                                class="h-11 w-full rounded-xl border border-gray-200 bg-white pl-10 pr-3 text-sm text-gray-800 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" />
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label class="sr-only">Kota</label>
                                        <select name="city"
                                            class="h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm text-gray-800 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                                            <option value="">Semua Kota</option>
                                            @foreach(($cityOptions ?? collect()) as $city)
                                                <option value="{{ $city }}" @selected(($filters['city'] ?? '') === $city)>{{ $city }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <button type="submit"
                                            class="inline-flex h-11 w-full items-center justify-center rounded-xl bg-blue-700 px-4 text-sm font-semibold text-white hover:bg-blue-800">
                                            Cari
                                        </button>
                                    </div>

                                    <div class="sm:col-span-4">
                                        <label class="sr-only">Tipe</label>
                                        <select name="type"
                                            class="h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm text-gray-800 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10">
                                            <option value="">Semua Tipe</option>
                                            @foreach (['Rumah','Apartemen','Tanah','Ruko','Villa'] as $t)
                                                <option value="{{ $t }}" @selected(($filters['type'] ?? '') === $t)>{{ $t }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label class="sr-only">Harga Min</label>
                                        <input name="price_min" value="{{ $filters['price_min'] ?? '' }}" inputmode="numeric" placeholder="Harga min"
                                            class="h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm text-gray-800 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" />
                                    </div>
                                    <div class="sm:col-span-4">
                                        <label class="sr-only">Harga Max</label>
                                        <input name="price_max" value="{{ $filters['price_max'] ?? '' }}" inputmode="numeric" placeholder="Harga max"
                                            class="h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm text-gray-800 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pointer-events-none absolute inset-x-0 bottom-0 h-12 bg-gray-50 rounded-t-[28px]"></div>
        </div>

        <div class="mx-auto max-w-[1200px] px-4 py-8">
            <div class="flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Properti Lelang di Indonesia</h2>
                    <p class="mt-1 text-sm text-gray-600">Menampilkan listing aset lelang bank yang tersedia.</p>
                </div>
                @if(($filters['q'] ?? '') !== '' || ($filters['city'] ?? '') !== '' || ($filters['type'] ?? '') !== '' || filled($filters['price_min'] ?? null) || filled($filters['price_max'] ?? null))
                    <a href="{{ route('aset-lelang-bank') }}" class="text-sm font-semibold text-blue-700 hover:underline">
                        Reset Filter
                    </a>
                @endif
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($properties as $property)
                    @php
                        $images = ($property->images ?? collect())->sortBy('sort_order')->values();
                        $primaryImage = $images->firstWhere('is_primary', true) ?? $images->first();
                        $imageSrc = $normalizeImage($primaryImage?->path) ?: $fallbackImages->random();

                        $addressText = collect([$property->address, $property->city, $property->province])->filter()->implode(', ');

                        $phone = preg_replace('/\\D+/', '', (string) ($property->agent?->phone ?? ''));
                        $whatsAppLink = $phone ? "https://wa.me/{$phone}" : null;
                    @endphp

                    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 transition hover:shadow-md">
                        <a href="{{ route('property.show', $property->slug ?: $property->getKey()) }}" class="block">
                            <div class="relative aspect-[4/3] bg-gray-200">
                                <img src="{{ $imageSrc }}" alt="{{ $property->title }}" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                                <div class="absolute left-3 top-3 flex items-center gap-2">
                                    <span class="rounded-full bg-blue-700 px-2.5 py-1 text-xs font-semibold text-white">Lelang</span>
                                    <span class="rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-gray-800">
                                        {{ $property->type ?: 'Properti' }}
                                    </span>
                                </div>
                            </div>
                        </a>

                        <div class="p-4">
                            <p class="text-lg font-extrabold text-blue-700">{{ $formatRupiah($property->price) }}</p>
                            <a href="{{ route('property.show', $property->slug ?: $property->getKey()) }}"
                                class="mt-1 block line-clamp-2 text-sm font-semibold text-gray-900 hover:text-blue-700">
                                {{ $property->title }}
                            </a>
                            <p class="mt-1 line-clamp-1 text-xs text-gray-500">
                                <i class="fa fa-map-marker mr-1"></i>
                                {{ $addressText ?: 'Lokasi belum diisi' }}
                            </p>

                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-600">
                                @if($property->bedrooms)
                                    <span class="inline-flex items-center gap-1">
                                        <i class="fa fa-bed text-blue-900"></i> {{ $property->bedrooms }} KT
                                    </span>
                                @endif
                                @if($property->bathrooms)
                                    <span class="inline-flex items-center gap-1">
                                        <i class="fa fa-bath text-blue-900"></i> {{ $property->bathrooms }} KM
                                    </span>
                                @endif
                                @if($property->land_area)
                                    <span class="inline-flex items-center gap-1">
                                        <i class="fa fa-expand text-blue-900"></i> {{ number_format((float) $property->land_area) }} m²
                                    </span>
                                @endif
                            </div>

                            <div class="mt-4 grid grid-cols-2 gap-2">
                                <a href="{{ route('property.show', $property->slug ?: $property->getKey()) }}"
                                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Detail
                                </a>
                                @if($whatsAppLink)
                                    <a href="{{ $whatsAppLink }}" target="_blank" rel="noopener"
                                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                        <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                    </a>
                                @else
                                    <button type="button" data-open-property-inquiry
                                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                        <i class="fa fa-comment-dots"></i> Tanya
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-gray-200 bg-white p-12 text-center">
                        <i class="fa fa-building-columns mb-3 text-4xl text-gray-300"></i>
                        <p class="text-gray-600">Belum ada aset lelang bank yang tersedia.</p>
                        <p class="mt-1 text-sm text-gray-500">Admin dapat menandai properti dengan kategori listing <span class="font-semibold">Aset Lelang Bank</span>.</p>
                    </div>
                @endforelse
            </div>

            @if(method_exists($properties, 'links'))
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @endif

            {{-- FAQ --}}
            <div class="mt-12">
                <h3 class="text-lg font-bold text-gray-900">Pertanyaan Seputar Aset Bank</h3>
                <div class="mt-4 divide-y divide-gray-200 overflow-hidden rounded-2xl bg-white ring-1 ring-black/5">
                    @foreach ([
                        ['q' => 'Apa itu aset lelang bank?', 'a' => 'Aset lelang bank adalah properti yang dilelang oleh bank/instansi terkait. Informasi harga, jadwal, dan ketentuan dapat berbeda-beda sesuai listing.'],
                        ['q' => 'Bagaimana proses pembelian aset lelang?', 'a' => 'Umumnya Anda perlu mengikuti prosedur lelang, menyiapkan dokumen, dan melakukan pembayaran sesuai ketentuan. Tim kami bisa membantu mengarahkan langkahnya.'],
                        ['q' => 'Apakah harga masih bisa nego?', 'a' => 'Tergantung ketentuan lelang/listing. Beberapa listing bersifat lelang murni, lainnya bisa bersifat penawaran tertentu.'],
                        ['q' => 'Apakah bisa KPR?', 'a' => 'Bisa untuk kasus tertentu. Silakan gunakan tombol WhatsApp/Tanya untuk konsultasi lebih lanjut.'],
                    ] as $item)
                        <details class="group p-5">
                            <summary class="flex cursor-pointer list-none items-center justify-between text-sm font-semibold text-gray-900">
                                <span>{{ $item['q'] }}</span>
                                <span class="text-gray-400 group-open:rotate-180 transition">
                                    <i class="fa fa-chevron-down"></i>
                                </span>
                            </summary>
                            <p class="mt-3 text-sm text-gray-600">{{ $item['a'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>

            {{-- About --}}
            <div class="mt-12 rounded-3xl bg-gradient-to-b from-blue-50 to-white p-6 ring-1 ring-blue-100">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                    <div class="lg:col-span-4">
                        <h3 class="text-lg font-bold text-gray-900">Tentang Properti Aset Bank</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Aset bank mencakup properti lelang maupun non-lelang. Pastikan Anda memahami ketentuan dan dokumen yang dibutuhkan.
                        </p>
                        <div class="mt-4 rounded-2xl bg-white p-4 text-sm text-gray-700 ring-1 ring-black/5">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-blue-700"><i class="fa fa-circle-info"></i></div>
                                <div>
                                    <p class="font-semibold">Tips:</p>
                                    <p class="mt-1 text-gray-600">Cek lokasi, legalitas, dan estimasi biaya sebelum mengikuti lelang.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-8">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="rounded-2xl bg-white p-5 ring-1 ring-blue-100">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-bold text-blue-700">Lelang</h4>
                                    <a href="{{ route('aset-lelang-bank') }}" class="text-xs font-semibold text-blue-700 hover:underline">Cari Aset Lelang</a>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">Properti dilelang dengan ketentuan tertentu.</p>
                                <ol class="mt-4 space-y-2 text-sm text-gray-700">
                                    <li class="flex gap-2"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-700 text-xs font-bold text-white">1</span> Cari listing yang sesuai</li>
                                    <li class="flex gap-2"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-700 text-xs font-bold text-white">2</span> Siapkan dokumen dan dana</li>
                                    <li class="flex gap-2"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-blue-700 text-xs font-bold text-white">3</span> Ikuti proses lelang</li>
                                </ol>
                            </div>

                            <div class="rounded-2xl bg-rose-700 p-5 text-white">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-bold">Non-Lelang</h4>
                                    <button type="button" data-open-property-inquiry class="text-xs font-semibold underline underline-offset-2">
                                        Cari Aset Non-Lelang
                                    </button>
                                </div>
                                <p class="mt-2 text-sm text-white/90">Properti aset bank dengan skema penjualan tertentu.</p>
                                <ol class="mt-4 space-y-2 text-sm text-white/95">
                                    <li class="flex gap-2"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-white/15 text-xs font-bold text-white">1</span> Konsultasi kebutuhan</li>
                                    <li class="flex gap-2"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-white/15 text-xs font-bold text-white">2</span> Survey lokasi</li>
                                    <li class="flex gap-2"><span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-white/15 text-xs font-bold text-white">3</span> Proses transaksi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
