@extends('agent.layouts.app')

@section('content')
    <div class="space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Property</h1>

        <form action="{{ route('agent.properties.update', $property) }}" method="POST" enctype="multipart/form-data"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                    <input name="title" value="{{ old('title', $property->title) }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Slug (Permalink)</label>
                    <input name="slug" value="{{ old('slug', $property->slug) }}" placeholder="otomatis dari judul jika kosong"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Jika dikosongkan, sistem akan membuat slug dari judul saat disimpan.</p>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Listing (Home)</label>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 dark:border-gray-800 dark:bg-gray-800/30 dark:text-gray-300">
                        <div class="flex flex-wrap gap-2">
                            @forelse(($property->listingCategories ?? collect())->sortBy('sort_order') as $cat)
                                <span class="rounded-full bg-brand-500/10 px-2 py-0.5 text-xs font-semibold text-brand-600 dark:text-brand-300">{{ $cat->name }}</span>
                            @empty
                                <span>-</span>
                            @endforelse
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Kategori ini ditentukan Admin. Jika Anda melakukan perubahan, properti akan kembali <span class="font-semibold">pending approval</span>.</p>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Fasilitas</label>
                    @php
                        $selectedFeatureIds = old(
                            'feature_ids',
                            ($property->features ?? collect())->pluck('id')->all(),
                        );
                    @endphp
                    @if(($features ?? collect())->count() > 0)
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach(($features ?? collect()) as $feature)
                                <label class="flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-800 dark:border-gray-800 dark:text-gray-200">
                                    <input
                                        type="checkbox"
                                        name="feature_ids[]"
                                        value="{{ $feature->id }}"
                                        @checked(in_array($feature->id, $selectedFeatureIds))
                                        class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500"
                                    />
                                    <span>{{ $feature->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Jika Anda mengubah data, properti akan kembali <span class="font-semibold">pending approval</span>.</p>
                    @else
                        <div class="rounded-lg border border-dashed border-gray-200 p-4 text-sm text-gray-500 dark:border-gray-800 dark:text-gray-400">
                            Data fasilitas belum ada. Silakan hubungi admin untuk mengisi data fasilitas.
                        </div>
                    @endif
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga</label>
                    <input name="price" value="{{ old('price', $property->price) }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Periode Harga</label>
                    <select name="price_period"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="one_time" @selected(old('price_period', $property->price_period) === 'one_time')>Sekali</option>
                        <option value="monthly" @selected(old('price_period', $property->price_period) === 'monthly')>Bulanan</option>
                        <option value="yearly" @selected(old('price_period', $property->price_period) === 'yearly')>Tahunan</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="dijual" @selected(old('status', $property->status)=='dijual')>Dijual</option>
                        <option value="disewakan" @selected(old('status', $property->status)=='disewakan')>Disewakan</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Properti</label>
                    <select name="type"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="Rumah" @selected(old('type', $property->type)=='Rumah')>Rumah</option>
                        <option value="Apartemen" @selected(old('type', $property->type)=='Apartemen')>Apartemen</option>
                        <option value="Kost" @selected(old('type', $property->type)=='Kost')>Kost</option>
                        <option value="Kos-kosan" @selected(old('type', $property->type)=='Kos-kosan')>Kos-kosan</option>
                        <option value="Villa" @selected(old('type', $property->type)=='Villa')>Villa</option>
                        <option value="Ruko" @selected(old('type', $property->type)=='Ruko')>Ruko</option>
                        <option value="Tanah" @selected(old('type', $property->type)=='Tanah')>Tanah</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kota</label>
                    <input name="city" value="{{ old('city', $property->city) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Provinsi</label>
                    <input name="province" value="{{ old('province', $property->province) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Pos</label>
                    <input name="postal_code" value="{{ old('postal_code', $property->postal_code) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Latitude</label>
                    <input name="latitude" value="{{ old('latitude', $property->latitude) }}" type="number" step="0.0000001"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Longitude</label>
                    <input name="longitude" value="{{ old('longitude', $property->longitude) }}" type="number" step="0.0000001"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kamar Tidur</label>
                    <input name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kamar Mandi</label>
                    <input name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Lantai</label>
                    <input name="floors" value="{{ old('floors', $property->floors) }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Carport</label>
                    <input name="carports" value="{{ old('carports', $property->carports) }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Garasi</label>
                    <input name="garages" value="{{ old('garages', $property->garages) }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Tanah (LT)</label>
                    <input name="land_area" value="{{ old('land_area', $property->land_area) }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Bangunan (LB)</label>
                    <input name="building_area" value="{{ old('building_area', $property->building_area) }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Sertifikat</label>
                    <select name="certificate"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="shm" @selected(old('certificate', $property->certificate)=='shm')>SHM</option>
                        <option value="shgb" @selected(old('certificate', $property->certificate)=='shgb')>SHGB</option>
                        <option value="girik" @selected(old('certificate', $property->certificate)=='girik')>Girik</option>
                        <option value="ajb" @selected(old('certificate', $property->certificate)=='ajb')>AJB</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Listrik</label>
                    <select name="electricity"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="450" @selected(old('electricity', $property->electricity)=='450')>450 VA</option>
                        <option value="900" @selected(old('electricity', $property->electricity)=='900')>900 VA</option>
                        <option value="1300" @selected(old('electricity', $property->electricity)=='1300')>1300 VA</option>
                        <option value="2200" @selected(old('electricity', $property->electricity)=='2200')>2200 VA</option>
                        <option value="3500" @selected(old('electricity', $property->electricity)=='3500')>3500 VA</option>
                        <option value="4400" @selected(old('electricity', $property->electricity)=='4400')>4400 VA</option>
                        <option value="5500" @selected(old('electricity', $property->electricity)=='5500')>5500 VA</option>
                        <option value="6600" @selected(old('electricity', $property->electricity)=='6600')>6600 VA</option>
                        <option value="7700" @selected(old('electricity', $property->electricity)=='7700')>7700 VA</option>
                        <option value="10600" @selected(old('electricity', $property->electricity)=='10600')>10600 VA</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Sumber Air</label>
                    <select name="water_source"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="pdam" @selected(old('water_source', $property->water_source)=='pdam')>PDAM</option>
                        <option value="well" @selected(old('water_source', $property->water_source)=='well')>Sumur</option>
                        <option value="jetpump" @selected(old('water_source', $property->water_source)=='jetpump')>Jetpump</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Furnishing</label>
                    <select name="furnishing"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="unfurnished" @selected(old('furnishing', $property->furnishing)=='unfurnished')>Unfurnished</option>
                        <option value="semi" @selected(old('furnishing', $property->furnishing)=='semi')>Semi Furnished</option>
                        <option value="furnished" @selected(old('furnishing', $property->furnishing)=='furnished')>Furnished</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Orientasi</label>
                    <select name="orientation"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                        <option value="">-</option>
                        <option value="north" @selected(old('orientation', $property->orientation)=='north')>Utara</option>
                        <option value="south" @selected(old('orientation', $property->orientation)=='south')>Selatan</option>
                        <option value="east" @selected(old('orientation', $property->orientation)=='east')>Timur</option>
                        <option value="west" @selected(old('orientation', $property->orientation)=='west')>Barat</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Bangun</label>
                    <input name="year_built" value="{{ old('year_built', $property->year_built) }}" type="number"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                    <input name="address" value="{{ old('address', $property->address) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('description', $property->description) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tambah Gambar</label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Upload tambahan gambar.</p>
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $property->is_published))
                            class="w-4 h-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500" />
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Terbitkan Properti</span>
                    </label>
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $property->is_featured))
                            class="w-4 h-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500" />
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Properti Unggulan</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan
                </button>
                <a href="{{ route('agent.properties.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>
@endsection
