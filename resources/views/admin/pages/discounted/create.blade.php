@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Tambah Aset Turun Harga</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Buat listing properti turun harga baru.</p>
            </div>
            <a href="{{ route('admin.discounted.index') }}" class="text-blue-600 hover:underline">
                <i class="fa fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.discounted.store') }}" method="POST" enctype="multipart/form-data"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            @csrf

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul <span class="text-red-500">*</span></label>
                    <input name="title" value="{{ old('title') }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Slug (Permalink)</label>
                    <input name="slug" value="{{ old('slug') }}" placeholder="otomatis dari judul jika kosong"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Contoh: rumah-minimalis-jakarta (tanpa spasi).</p>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Baru (Rp) <span class="text-red-500">*</span></label>
                    <input name="price" value="{{ old('price') }}" type="number" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white"
                        placeholder="Harga setelah diskon" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Awal (Rp) <span class="text-red-500">*</span></label>
                    <input name="original_price" value="{{ old('original_price') }}" type="number" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white"
                        placeholder="Harga sebelum diskon" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Harga asli sebelum diterapkan diskon</p>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="dijual" {{ old('status')=='dijual'?'selected':'' }}>Dijual</option>
                        <option value="disewakan" {{ old('status')=='disewakan'?'selected':'' }}>Disewakan</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Properti</label>
                    <select name="type"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="Rumah" {{ old('type')=='Rumah'?'selected':'' }}>Rumah</option>
                        <option value="Apartemen" {{ old('type')=='Apartemen'?'selected':'' }}>Apartemen</option>
                        <option value="Kost" {{ old('type')=='Kost'?'selected':'' }}>Kost</option>
                        <option value="Kos-kosan" {{ old('type')=='Kos-kosan'?'selected':'' }}>Kos-kosan</option>
                        <option value="Villa" {{ old('type')=='Villa'?'selected':'' }}>Villa</option>
                        <option value="Ruko" {{ old('type')=='Ruko'?'selected':'' }}>Ruko</option>
                        <option value="Tanah" {{ old('type')=='Tanah'?'selected':'' }}>Tanah</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kota</label>
                    <input name="city" value="{{ old('city') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Provinsi</label>
                    <input name="province" value="{{ old('province') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                    <input name="address" value="{{ old('address') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Pos</label>
                    <input name="postal_code" value="{{ old('postal_code') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kamar Tidur</label>
                    <input name="bedrooms" value="{{ old('bedrooms') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kamar Mandi</label>
                    <input name="bathrooms" value="{{ old('bathrooms') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Tanah (m²)</label>
                    <input name="land_area" value="{{ old('land_area') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Bangunan (m²)</label>
                    <input name="building_area" value="{{ old('building_area') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Sertifikat</label>
                    <select name="certificate"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">Pilih Sertifikat</option>
                        <option value="SHM" {{ old('certificate')=='SHM'?'selected':'' }}>SHM (Sertifikat Hak Milik)</option>
                        <option value="HGB" {{ old('certificate')=='HGB'?'selected':'' }}>HGB (Hak Guna Bangunan)</option>
                        <option value="L证" {{ old('certificate')=='L证'?'selected':'' }}>L证 (Leleasehold)</option>
                        <option value="Girik" {{ old('certificate')=='Girik'?'selected':'' }}>Girik</option>
                        <option value="AJB" {{ old('certificate')=='AJB'?'selected':'' }}>AJB (Akta Jual Beli)</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Furnishing</label>
                    <select name="furnishing"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">Pilih Furnishing</option>
                        <option value="Furnished" {{ old('furnishing')=='Furnished'?'selected':'' }}>Furnished (Berisi)</option>
                        <option value="Unfurnished" {{ old('furnishing')=='Unfurnished'?'selected':'' }}>Unfurnished (Kosong)</option>
                        <option value="Semi Furnished" {{ old('furnishing')=='Semi Furnished'?'selected':'' }}>Semi Furnished</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('description') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                            class="w-4 h-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500" />
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Terbitkan Properti</span>
                    </label>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Listing (Home)</label>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach(($listingCategories ?? collect()) as $cat)
                            <label class="flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-800 dark:border-gray-800 dark:text-gray-200">
                                <input
                                    type="checkbox"
                                    name="listing_category_ids[]"
                                    value="{{ $cat->id }}"
                                    @checked(in_array($cat->id, old('listing_category_ids', [])))
                                    class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500"
                                />
                                <span>{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Fasilitas</label>
                    @if(($features ?? collect())->count() > 0)
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach(($features ?? collect()) as $feature)
                                <label class="flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-800 dark:border-gray-800 dark:text-gray-200">
                                    <input
                                        type="checkbox"
                                        name="feature_ids[]"
                                        value="{{ $feature->id }}"
                                        @checked(in_array($feature->id, old('feature_ids', [])))
                                        class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500"
                                    />
                                    <span>{{ $feature->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Belum ada fitur tersedia.</p>
                    @endif
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Properti</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Anda dapat memilih lebih dari satu gambar.</p>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit"
                    class="rounded-lg bg-red-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-red-700">
                    <i class="fa fa-save mr-1"></i> Simpan Aset Turun Harga
                </button>
                <a href="{{ route('admin.discounted.index') }}"
                    class="rounded-lg bg-gray-200 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
