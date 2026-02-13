@php
    /** @var \App\Models\Property|null $property */
    $property = $property ?? null;
    $isEdit = $property && $property->exists;
    $formAction = $isEdit ? route('admin.rumah-subsidi.update', $property) : route('admin.rumah-subsidi.store');
    $buttonText = $isEdit ? 'Perbarui' : 'Simpan';
@endphp

@if ($errors->any())
    <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <div class="font-semibold">Ada kesalahan pada input:</div>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $formAction }}" method="POST" enctype="multipart/form-data"
    class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="md:col-span-2">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Judul <span class="text-red-500">*</span></label>
            <input name="title" value="{{ old('title', $property?->title ?? '') }}" required placeholder="Contoh: Rumah Subsidi Griya Melati"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
            <input name="slug" value="{{ old('slug', $property?->slug ?? '') }}" placeholder="otomatis dari judul jika kosong"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga (Rp) <span class="text-red-500">*</span></label>
            <input name="price" value="{{ old('price', $property?->price ?? '') }}" type="number" required placeholder="150000000"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kota <span class="text-red-500">*</span></label>
            <input name="city" value="{{ old('city', $property?->city ?? '') }}" required placeholder="Padang"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Provinsi</label>
            <input name="province" value="{{ old('province', $property?->province ?? '') }}" placeholder="Sumatera Barat"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
            <input name="address" value="{{ old('address', $property?->address ?? '') }}" placeholder="Jl. Raya Contoh No. 123"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kamar Tidur</label>
            <input name="bedrooms" value="{{ old('bedrooms', $property?->bedrooms ?? '') }}" type="number" placeholder="2"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kamar Mandi</label>
            <input name="bathrooms" value="{{ old('bathrooms', $property?->bathrooms ?? '') }}" type="number" placeholder="1"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Tanah (m²)</label>
            <input name="land_area" value="{{ old('land_area', $property?->land_area ?? '') }}" type="number" placeholder="72"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Luas Bangunan (m²)</label>
            <input name="building_area" value="{{ old('building_area', $property?->building_area ?? '') }}" type="number" placeholder="45"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Sertifikat</label>
            <select name="certificate"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                <option value="">Pilih...</option>
                @foreach (['SHM','HGB','AJB','GIRIK'] as $c)
                    <option value="{{ strtolower($c) }}" @selected(strtolower(old('certificate', $property?->certificate ?? '')) === strtolower($c))>{{ $c }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Sumber Air</label>
            <select name="water_source"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                <option value="">Pilih...</option>
                <option value="pdam" @selected(old('water_source', $property?->water_source ?? '') === 'pdam')>PDAM</option>
                <option value="well" @selected(old('water_source', $property?->water_source ?? '') === 'well')>Sumur</option>
                <option value="jetpump" @selected(old('water_source', $property?->water_source ?? '') === 'jetpump')>Jetpump</option>
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Furnishing</label>
            <select name="furnishing"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                <option value="">Pilih...</option>
                <option value="unfurnished" @selected(old('furnishing', $property?->furnishing ?? '') === 'unfurnished')>Unfurnished</option>
                <option value="semi" @selected(old('furnishing', $property?->furnishing ?? '') === 'semi')>Semi Furnished</option>
                <option value="furnished" @selected(old('furnishing', $property?->furnishing ?? '') === 'furnished')>Furnished</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
            <textarea name="description" rows="4" placeholder="Deskripsi rumah subsidi..."
                class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white">{{ old('description', $property?->description ?? '') }}</textarea>
        </div>

        @if($isEdit && ($property->images ?? collect())->count() > 0)
            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Saat Ini</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($property->images as $image)
                        @php
                            $imgPath = (string) ($image->path ?? '');
                            if (str_starts_with($imgPath, '/storage/')) {
                                $imgPath = $imgPath;
                            } elseif ($imgPath !== '' && !str_starts_with($imgPath, 'http')) {
                                $imgPath = '/storage/' . ltrim($imgPath, '/');
                            }
                        @endphp
                        <img src="{{ $imgPath }}" alt="Foto properti" class="h-20 w-20 rounded-lg border border-gray-200 object-cover">
                    @endforeach
                </div>
            </div>
        @endif

        <div class="md:col-span-2">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Properti</label>
            <input type="file" name="images[]" multiple accept="image/*"
                class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-green-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-green-700 hover:file:bg-green-100" />
            <p class="mt-1 text-xs text-gray-500">Upload foto properti baru (bisa pilih lebih dari 1). Foto lama akan dipertahankan.</p>
        </div>
    </div>

    <div class="mt-6 flex items-center gap-4">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $property?->is_published ?? true) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" />
            <span class="text-sm text-gray-700 dark:text-gray-300">Publikasikan</span>
        </label>
        <label class="flex items-center gap-2">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $property?->is_featured ?? false) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" />
            <span class="text-sm text-gray-700 dark:text-gray-300">Tandai Unggulan</span>
        </label>
    </div>

    <div class="mt-6 flex gap-4">
        <button type="submit" class="rounded-lg bg-green-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
            <i class="fa fa-save mr-2"></i> {{ $buttonText }}
        </button>
        <a href="{{ route('admin.rumah-subsidi.index') }}" class="rounded-lg bg-gray-100 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200">
            Batal
        </a>
    </div>
</form>
