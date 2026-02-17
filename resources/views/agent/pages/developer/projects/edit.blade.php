@extends('agent.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Proyek" />

    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90">Edit Proyek</h3>
        
        <form action="{{ route('agent.developer-projects.update', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Basic Info -->
                <div class="md:col-span-2">
                    <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Informasi Dasar</h4>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Proyek <span class="text-red-500">*</span></label>
                    <input name="name" value="{{ old('name', $project->name) }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                    <input name="slug" value="{{ old('slug', $project->slug) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Logo Proyek</label>
                    @if($project->logo)
                        <div class="mb-2">
                            <img src="{{ $project->logo }}" alt="Logo" class="h-16 w-16 rounded-lg object-cover">
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*"
                        class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Video URL</label>
                    <input name="video_url" type="url" value="{{ old('video_url', $project->video_url) }}" placeholder="https://youtube.com/..."
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <!-- Project Images -->
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Proyek</label>
                    @if(!empty($project->images))
                        <div class="mb-3 flex flex-wrap gap-2">
                            @foreach($project->images as $index => $image)
                                <div class="relative group">
                                    <img src="{{ $image }}" alt="Image {{ $index + 1 }}" class="h-20 w-20 rounded-lg object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="images[]" accept="image/*" multiple
                        class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                    <p class="mt-1 text-xs text-gray-500">Dapat memilih beberapa gambar sekaligus. Maks 5MB per gambar.</p>
                </div>

                <!-- Location -->
                <div class="md:col-span-2 mt-4">
                    <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Lokasi</h4>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                    <input name="address" value="{{ old('address', $project->address) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kota <span class="text-red-500">*</span></label>
                    <input name="city" value="{{ old('city', $project->city) }}" required
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Provinsi</label>
                    <input name="province" value="{{ old('province', $project->province) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <!-- Pricing -->
                <div class="md:col-span-2 mt-4">
                    <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Harga</h4>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Mulai</label>
                    <input name="price_start" type="number" value="{{ old('price_start', $project->price_start) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Harga Sampai</label>
                    <input name="price_end" type="number" value="{{ old('price_end', $project->price_end) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <!-- Project Details -->
                <div class="md:col-span-2 mt-4">
                    <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Detail Proyek</h4>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Total Unit</label>
                    <input name="total_units" type="number" value="{{ old('total_units', $project->total_units) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Unit Tersedia</label>
                    <input name="available_units" type="number" value="{{ old('available_units', $project->available_units) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Brosur (PDF)</label>
                    @if($project->brochure)
                        <div class="mb-2">
                            <a href="{{ $project->brochure }}" target="_blank" class="text-sm text-brand-500 hover:underline">Lihat Brosur Saat Ini</a>
                        </div>
                    @endif
                    <input type="file" name="brochure" accept=".pdf"
                        class="block w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-500 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-brand-600 dark:border-gray-800 dark:text-gray-300" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">
                        <option value="active" {{ $project->status === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="on-hold" {{ $project->status === 'on-hold' ? 'selected' : '' }}>Ditunda</option>
                        <option value="cancelled" {{ $project->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                    <input name="start_date" type="date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                    <input name="end_date" type="date" value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                        class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white" />
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full rounded-lg border border-gray-200 bg-transparent px-4 py-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-800 dark:text-white">{{ old('description', $project->description) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_published" value="1" {{ $project->is_published ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Publikasikan proyek</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-theme-xs hover:bg-brand-600">
                    Simpan Perubahan
                </button>
                <a href="{{ route('agent.developer-projects.show', $project) }}" class="text-sm text-gray-600 hover:underline dark:text-gray-300">Batal</a>
            </div>
        </form>
    </div>
@endsection