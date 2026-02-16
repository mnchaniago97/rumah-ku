<form action="{{ route('properties') }}" method="GET" class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5">
    <div class="flex items-center justify-between">
        <h2 class="text-sm font-extrabold text-gray-900">Filter</h2>
        <a href="{{ route('properties') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-800">Reset</a>
    </div>

    <input type="hidden" name="sort" value="{{ request('sort') }}">

    <div class="mt-4 space-y-4">
        <div>
            <label class="text-xs font-semibold text-gray-700">Keyword</label>
            <input name="q" value="{{ request('q') }}" placeholder="Lokasi / keyword"
                class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm focus:ring-2 focus:ring-blue-600">
        </div>

        <div>
            <label class="text-xs font-semibold text-gray-700">Kota</label>
            <select name="city"
                class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                <option value="">Semua Kota</option>
                @foreach(($cityOptions ?? collect()) as $city)
                    <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-xs font-semibold text-gray-700">Tipe</label>
            <select name="type"
                class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-3 text-sm focus:ring-2 focus:ring-blue-600">
                <option value="">Semua Tipe</option>
                @foreach(($typeOptions ?? collect()) as $t)
                    <option value="{{ $t }}" @selected(request('type') === $t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-xs font-semibold text-gray-700">Min Harga</label>
                <input name="min_price" type="number" inputmode="numeric" value="{{ request('min_price') }}"
                    placeholder="0"
                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-700">Max Harga</label>
                <input name="max_price" type="number" inputmode="numeric" value="{{ request('max_price') }}"
                    placeholder="500000000"
                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-xs font-semibold text-gray-700">Min K. Tidur</label>
                <input name="bedrooms" type="number" inputmode="numeric" min="0" value="{{ request('bedrooms') }}"
                    placeholder="0"
                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-700">Min K. Mandi</label>
                <input name="bathrooms" type="number" inputmode="numeric" min="0" value="{{ request('bathrooms') }}"
                    placeholder="0"
                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-xs font-semibold text-gray-700">Min LT (m²)</label>
                <input name="min_land_area" type="number" inputmode="numeric" min="0" value="{{ request('min_land_area') }}"
                    placeholder="0"
                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-700">Max LT (m²)</label>
                <input name="max_land_area" type="number" inputmode="numeric" min="0" value="{{ request('max_land_area') }}"
                    placeholder="300"
                    class="mt-1 h-11 w-full rounded-xl border border-gray-200 bg-gray-50 px-4 text-sm focus:ring-2 focus:ring-blue-600">
            </div>
        </div>
    </div>

    <button type="submit"
        class="mt-5 inline-flex h-11 w-full items-center justify-center rounded-xl bg-blue-600 px-4 text-sm font-semibold text-white hover:bg-blue-700">
        Terapkan Filter
    </button>
</form>
