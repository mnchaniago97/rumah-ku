@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create Property</h1>

        <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            @csrf

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
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
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga</label>
                    <input name="price" value="{{ old('price') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
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
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Lantai</label>
                    <input name="floors" value="{{ old('floors') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Carport</label>
                    <input name="carports" value="{{ old('carports') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Garasi</label>
                    <input name="garages" value="{{ old('garages') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Tanah (LT)</label>
                    <input name="land_area" value="{{ old('land_area') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Bangunan (LB)</label>
                    <input name="building_area" value="{{ old('building_area') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Sertifikat</label>
                    <select name="certificate"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="shm" {{ old('certificate')=='shm'?'selected':'' }}>SHM</option>
                        <option value="shgb" {{ old('certificate')=='shgb'?'selected':'' }}>SHGB</option>
                        <option value="girik" {{ old('certificate')=='girik'?'selected':'' }}>Girik</option>
                        <option value="ajb" {{ old('certificate')=='ajb'?'selected':'' }}>AJB</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Listrik</label>
                    <select name="electricity"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="450" {{ old('electricity')=='450'?'selected':'' }}>450 VA</option>
                        <option value="900" {{ old('electricity')=='900'?'selected':'' }}>900 VA</option>
                        <option value="1300" {{ old('electricity')=='1300'?'selected':'' }}>1300 VA</option>
                        <option value="2200" {{ old('electricity')=='2200'?'selected':'' }}>2200 VA</option>
                        <option value="3500" {{ old('electricity')=='3500'?'selected':'' }}>3500 VA</option>
                        <option value="4400" {{ old('electricity')=='4400'?'selected':'' }}>4400 VA</option>
                        <option value="5500" {{ old('electricity')=='5500'?'selected':'' }}>5500 VA</option>
                        <option value="6600" {{ old('electricity')=='6600'?'selected':'' }}>6600 VA</option>
                        <option value="7700" {{ old('electricity')=='7700'?'selected':'' }}>7700 VA</option>
                        <option value="10600" {{ old('electricity')=='10600'?'selected':'' }}>10600 VA</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Sumber Air</label>
                    <select name="water_source"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="pdam" {{ old('water_source')=='pdam'?'selected':'' }}>PDAM</option>
                        <option value="well" {{ old('water_source')=='well'?'selected':'' }}>Sumur</option>
                        <option value="jetpump" {{ old('water_source')=='jetpump'?'selected':'' }}>Jetpump</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Furnishing</label>
                    <select name="furnishing"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="unfurnished" {{ old('furnishing')=='unfurnished'?'selected':'' }}>Unfurnished</option>
                        <option value="semi" {{ old('furnishing')=='semi'?'selected':'' }}>Semi Furnished</option>
                        <option value="furnished" {{ old('furnishing')=='furnished'?'selected':'' }}>Furnished</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Orientasi</label>
                    <select name="orientation"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="north" {{ old('orientation')=='north'?'selected':'' }}>Utara</option>
                        <option value="south" {{ old('orientation')=='south'?'selected':'' }}>Selatan</option>
                        <option value="east" {{ old('orientation')=='east'?'selected':'' }}>Timur</option>
                        <option value="west" {{ old('orientation')=='west'?'selected':'' }}>Barat</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Bangun</label>
                    <input name="year_built" value="{{ old('year_built') }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                    <input name="address" value="{{ old('address') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
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
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                            class="w-4 h-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500" />
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Properti Unggulan</span>
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
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kategori ini menentukan properti tampil di section halaman Home (Rekomendasi, Pilihan Kami, Populer, dll).</p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Jika tidak dipilih, otomatis masuk kategori <span class="font-semibold">Properti Baru</span>.</p>
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
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Pilih fasilitas yang tersedia pada properti ini.</p>
                    @else
                        <div class="rounded-lg border border-dashed border-gray-200 p-4 text-sm text-gray-500 dark:border-gray-800 dark:text-gray-400">
                            Data fasilitas belum ada. Tambahkan data fasilitas di tabel <code class="font-mono">features</code> (seed) terlebih dahulu.
                        </div>
                    @endif
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Properti</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Bisa upload lebih dari satu gambar.</p>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan
                </button>
                <a href="{{ route('admin.properties.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>
@endsection
