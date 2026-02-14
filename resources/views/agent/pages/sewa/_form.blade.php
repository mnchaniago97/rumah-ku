@php
    /** @var \App\Models\Property|null $property */
    $property = $property ?? null;
    $isEdit = $property && $property->exists;
    $formAction = $isEdit ? route('agent.sewa.update', $property) : route('agent.sewa.store');
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
            <input name="title" value="{{ old('title', $property?->title ?? '') }}" required placeholder="Contoh: Rumah Sewa Griya Melati"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
            <input name="slug" value="{{ old('slug', $property?->slug ?? '') }}" placeholder="otomatis dari judul jika kosong"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga (Rp) <span class="text-red-500">*</span></label>
            <input name="price" value="{{ old('price', $property?->price ?? '') }}" type="number" required placeholder="5000000"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Periode Harga</label>
            <select name="price_period"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm dark:border-gray-800 dark:text-white">
                <option value="">Pilih...</option>
                <option value="bulan" @selected(old('price_period', $property?->price_period ?? '') === 'bulan')>Per Bulan</option>
                <option value="tahun" @selected(old('price_period', $property?->price_period ?? '') === 'tahun')>Per Tahun</option>
                <option value="hari" @selected(old('price_period', $property?->price_period ?? '') === 'hari')>Per Hari</option>
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kota <span class="text-red-500">*</span></label>
            <input name="city" value="{{ old('city', $property?->city ?? '') }}" required placeholder="Jakarta"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Provinsi</label>
            <input name="province" value="{{ old('province', $property?->province ?? '') }}" placeholder="DKI Jakarta"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">No WhatsApp</label>
            <input name="whatsapp_phone" value="{{ old('whatsapp_phone', $property?->whatsapp_phone ?? (auth()->user()?->whatsapp_phone ?? '')) }}" placeholder="62xxxxxxxxxxx"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
            <input name="address" value="{{ old('address', $property?->address ?? '') }}" placeholder="Alamat lengkap"
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white" />
        </div>

        <div class="md:col-span-2">
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
            <textarea name="description" rows="4" placeholder="Deskripsi properti sewa..."
                class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-2 text-sm text-gray-800 focus:border-green-500 focus:outline-hidden focus:ring-3 focus:ring-green-500/10 dark:border-gray-800 dark:text-white">{{ old('description', $property?->description ?? '') }}</textarea>
        </div>

        @if($isEdit && ($property->images ?? collect())->count() > 0)
            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Saat Ini</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($property->images as $image)
                        @php
                            $imgPath = (string) ($image->path ?? '');
                            if ($imgPath !== '' && !str_starts_with($imgPath, 'http') && !str_starts_with($imgPath, '/')) {
                                $imgPath = '/storage/' . ltrim($imgPath, '/');
                            }
                        @endphp
                        <img src="{{ $imgPath }}" alt="Foto properti" class="h-20 w-20 rounded-lg border border-gray-200 object-cover dark:border-gray-800">
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
        <a href="{{ route('agent.sewa.index') }}" class="rounded-lg bg-gray-100 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200">
            Batal
        </a>
    </div>
</form>

