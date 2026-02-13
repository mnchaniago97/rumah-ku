@extends('admin.layouts.app')

@section('title', 'Tambah Testimoni')

@section('content')
    <div class="w-full">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Testimoni</h1>
            <p class="text-gray-600">Tambahkan testimoni baru untuk ditampilkan di website</p>
        </div>

        <div class="w-full bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role (Opsional)</label>
                        <input type="text" name="role" value="{{ old('role') }}" placeholder="Contoh: Pembeli Rumah"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('role')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konten Testimoni</label>
                        <textarea name="content" rows="4" placeholder="Tulis testimoni..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <select name="rating"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ (int) old('rating', 5) === $i ? 'selected' : '' }}>{{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('rating')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="is_active"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', 0) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto (Opsional)</label>
                        <input type="file" name="photo" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @error('photo')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex gap-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.testimonials.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

