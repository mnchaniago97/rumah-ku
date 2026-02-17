@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Proyek</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Ubah detail proyek developer.</p>
        </div>
        <a href="{{ route('admin.developer-projects.show', $project) }}" class="text-sm font-semibold text-gray-700 hover:underline dark:text-gray-200">Kembali</a>
    </div>

    <form action="{{ route('admin.developer-projects.update', $project) }}" method="POST" class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
        @csrf
        @method('PUT')

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Nama Proyek</label>
                <input type="text" name="name" value="{{ old('name', $project->name) }}" required
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Slug (URL)</label>
                <input type="text" name="slug" value="{{ old('slug', $project->slug) }}" placeholder="otomatis dari nama jika kosong"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Alamat</label>
                <input type="text" name="address" value="{{ old('address', $project->address) }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Kota</label>
                <input type="text" name="city" value="{{ old('city', $project->city) }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Provinsi</label>
                <input type="text" name="province" value="{{ old('province', $project->province) }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Harga Mulai (Rp)</label>
                <input type="number" name="price_start" value="{{ old('price_start', $project->price_start) }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Harga Sampai (Rp)</label>
                <input type="number" name="price_end" value="{{ old('price_end', $project->price_end) }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Total Unit</label>
                <input type="number" name="total_units" value="{{ old('total_units', $project->total_units) }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Unit Tersedia</label>
                <input type="number" name="available_units" value="{{ old('available_units', $project->available_units) }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                    class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Status</label>
                <select name="status" class="mt-2 h-10 w-full rounded-lg border border-gray-200 bg-white px-3 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">
                    <option value="active" @selected(old('status', $project->status) === 'active')>Aktif</option>
                    <option value="completed" @selected(old('status', $project->status) === 'completed')>Selesai</option>
                    <option value="on-hold" @selected(old('status', $project->status) === 'on-hold')>Ditunda</option>
                    <option value="cancelled" @selected(old('status', $project->status) === 'cancelled')>Dibatalkan</option>
                </select>
            </div>
            <div>
                <label class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white mt-6">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $project->is_published)) />
                    Publikasikan
                </label>
            </div>
            <div class="md:col-span-2">
                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="mt-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white">{{ old('description', $project->description) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                Simpan
            </button>
            <a href="{{ route('admin.developer-projects.show', $project) }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
