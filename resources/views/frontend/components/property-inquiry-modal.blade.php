@php
    $types = [
        'Rumah',
        'Apartemen',
        'Tanah',
        'Ruko',
        'Villa',
        'Gudang',
        'Kost',
        'Kantor',
    ];
@endphp

<div id="property-inquiry-modal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/50" data-close-property-inquiry></div>

    <div class="relative mx-auto mt-10 w-[94%] max-w-xl rounded-2xl bg-white shadow-2xl max-h-[85vh] flex flex-col overflow-hidden">
        <div class="flex items-center justify-between flex-shrink-0 rounded-t-2xl border-b border-gray-100 px-5 py-4 bg-white z-10">
            <div>
                <h3 class="text-base font-bold text-gray-900">Bantu Carikan Properti</h3>
                <p class="mt-0.5 text-xs text-gray-500">Isi data singkat, admin akan menghubungi Anda.</p>
            </div>
            <button type="button" class="h-9 w-9 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200"
                data-close-property-inquiry>
                <i class="fa fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('property-inquiries.store') }}" method="POST" class="p-5 overflow-y-auto max-h-[calc(85vh-80px)]">
            @csrf

            @if (session('success'))
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-semibold text-gray-800">Saya ingin <span class="text-red-500">*</span></label>
                    <div class="mt-2 flex items-center gap-2">
                        <label class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm">
                            <input type="radio" name="intent" value="buy" checked class="h-4 w-4 text-blue-600">
                            <span>Beli</span>
                        </label>
                        <label class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm">
                            <input type="radio" name="intent" value="rent" class="h-4 w-4 text-blue-600">
                            <span>Sewa</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-800">Properti yang saya inginkan</label>
                    <p class="mt-1 text-xs text-gray-500">Bisa pilih lebih dari 1.</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @foreach ($types as $type)
                            @php $id = 'ptype_' . \Illuminate\Support\Str::slug($type, '_'); @endphp
                            <div>
                                <input id="{{ $id }}" type="checkbox" name="property_types[]" value="{{ $type }}" class="peer hidden">
                                <label for="{{ $id }}"
                                    class="cursor-pointer rounded-full border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700">
                                    {{ $type }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-800">Lokasi Properti</label>
                    <div class="mt-2 flex items-center gap-2 rounded-xl border border-gray-200 px-3 py-2">
                        <i class="fa fa-location-dot text-gray-400"></i>
                        <input name="location" placeholder="Masukkan nama area/kota"
                            class="w-full bg-transparent text-sm text-gray-900 placeholder-gray-400 focus:outline-none" />
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-800">Kisaran Harga Properti</label>
                    <div class="mt-2 grid grid-cols-2 gap-3">
                        <div class="flex items-center gap-2 rounded-xl border border-gray-200 px-3 py-2">
                            <span class="text-xs font-semibold text-gray-500">Rp</span>
                            <input name="price_min" type="number" min="0" placeholder="Min"
                                class="w-full bg-transparent text-sm text-gray-900 placeholder-gray-400 focus:outline-none" />
                        </div>
                        <div class="flex items-center gap-2 rounded-xl border border-gray-200 px-3 py-2">
                            <span class="text-xs font-semibold text-gray-500">Rp</span>
                            <input name="price_max" type="number" min="0" placeholder="Max"
                                class="w-full bg-transparent text-sm text-gray-900 placeholder-gray-400 focus:outline-none" />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-gray-800">Nama <span class="text-red-500">*</span></label>
                        <input name="name" required placeholder="Nama"
                            class="mt-2 h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-800">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input name="phone" required placeholder="+62xxxx"
                            class="mt-2 h-11 w-full rounded-xl border border-gray-200 bg-white px-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <div class="flex items-start gap-3">
                        <div class="mt-1 h-10 w-10 flex items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                            <i class="fa fa-hand-holding-dollar"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">Beli Properti Lebih Mudah dengan KPR</p>
                            <p class="mt-0.5 text-xs text-gray-600">Jika Anda ingin dibantu KPR, centang opsi di bawah.</p>
                            <label class="mt-3 inline-flex items-center gap-2 text-sm">
                                <input type="checkbox" name="wants_kpr" value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600">
                                <span>Saya tertarik</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-800">Catatan (opsional)</label>
                    <textarea name="notes" rows="3" placeholder="Contoh: butuh dekat sekolah, 3 kamar, siap huni, dll."
                        class="mt-2 w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"></textarea>
                </div>

                <button type="submit" class="mt-1 h-11 w-full rounded-xl bg-blue-700 text-sm font-semibold text-white hover:bg-blue-800">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const modal = document.getElementById('property-inquiry-modal');
        if (!modal) return;

        const openButtons = document.querySelectorAll('[data-open-property-inquiry]');
        const closeButtons = modal.querySelectorAll('[data-close-property-inquiry]');

        const open = () => {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        const close = () => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        };

        openButtons.forEach((btn) => btn.addEventListener('click', (e) => {
            e.preventDefault();
            open();
        }));

        closeButtons.forEach((btn) => btn.addEventListener('click', (e) => {
            e.preventDefault();
            close();
        }));

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) close();
        });

        // Auto open if just submitted successfully (flash on same page)
        @if (session('success'))
            open();
        @endif
    })();
</script>
