@extends('admin.layouts.app')

@section('title', 'Tambah Banner')

@section('content')
    <div class="w-full">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Banner</h1>
            <p class="text-gray-600">Tambahkan banner baru untuk ditampilkan di website</p>
        </div>

        <div class="w-full bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Banner</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan judul banner"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Banner</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition cursor-pointer">
                            <input type="file" name="image" id="image" accept="image/*" class="hidden">
                            <label for="image" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-600">Klik untuk upload gambar</p>
                                <p class="text-sm text-gray-400 mt-1">JPG, PNG, GIF maksimal 2MB</p>
                            </label>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <div id="image-preview" class="mt-4 hidden">
                            <img id="preview-img" src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg">
                        </div>
                    </div>

                    <!-- Link -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Banner</label>
                        <input type="url" name="link" value="{{ old('link') }}" placeholder="https://example.com"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('link')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Position -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Posisi Banner</label>
                        <select name="position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <option value="home">Halaman Utama</option>
                            <option value="property">Halaman Properti</option>
                            <option value="sidebar">Sidebar</option>
                            <option value="popup">Popup</option>
                        </select>
                        @error('position')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Penempatan</label>
                        <select name="location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <option value="hero" {{ ($location ?? 'hero') === 'hero' ? 'selected' : '' }}>Hero Banner (Atas)</option>
                            <option value="ads_1" {{ ($location ?? '') === 'ads_1' ? 'selected' : '' }}>Banner Iklan 1</option>
                            <option value="ads_2" {{ ($location ?? '') === 'ads_2' ? 'selected' : '' }}>Banner Iklan 2</option>
                            <option value="ads_3" {{ ($location ?? '') === 'ads_3' ? 'selected' : '' }}>Banner Iklan 3</option>
                            <option value="bottom" {{ ($location ?? '') === 'bottom' ? 'selected' : '' }}>Banner Bawah</option>
                            <option value="property_detail_sidebar" {{ ($location ?? '') === 'property_detail_sidebar' ? 'selected' : '' }}>Iklan Detail Properti (Sidebar)</option>
                        </select>
                        @error('location')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir (Opsional)</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <div class="mt-6 flex gap-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
