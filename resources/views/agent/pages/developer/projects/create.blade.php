@extends('agent.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Proyek" />

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90">Tambah Proyek Baru</h3>
        
        <form action="{{ route('agent.developer-projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Basic Info -->
                <div class="md:col-span-2">
                    <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Informasi Dasar</h4>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Proyek <span class="text-red-500">*</span></label>
                    <input name="name" value="{{ old('name') }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                    <input name="slug" value="{{ old('slug') }}" placeholder="akan dibuat otomatis jika dikosongkan"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Logo Proyek</label>
                    <input type="file" name="logo" accept="image/*"
                        class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Video URL</label>
                    <input name="video_url" type="url" value="{{ old('video_url') }}" placeholder="https://youtube.com/..."
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <!-- Location -->
                <div class="md:col-span-2 mt-4">
                    <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Lokasi</h4>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                    <input name="address" value="{{ old('address') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kota <span class="text-red-500">*</span></label>
                    <input name="city" value="{{ old('city') }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Provinsi</label>
                    <input name="province" value="{{ old('province') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <!-- Pricing -->
                <div class="md:col-span-2 mt-4">
                    <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Harga</h4>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Mulai</label>
                    <input name="price_start" type="number" value="{{ old('price_start') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Sampai</label>
                    <input name="price_end" type="number" value="{{ old('price_end') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <!-- Project Details -->
                <div class="md:col-span-2 mt-4">
                    <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Detail Proyek</h4>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Total Unit</label>
                    <input name="total_units" type="number" value="{{ old('total_units') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Brosur (PDF)</label>
                    <input type="file" name="brochure" accept=".pdf"
                        class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                    <input name="start_date" type="date" value="{{ old('start_date') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                    <input name="end_date" type="date" value="{{ old('end_date') }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan Proyek
                </button>
                <a href="{{ route('agent.developer-projects.index') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>
@endsection