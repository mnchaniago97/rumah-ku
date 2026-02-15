@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Aset Turun Harga</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Edit status turun harga properti.</p>
            </div>
            <a href="{{ route('admin.discounted.index') }}" class="text-blue-600 hover:underline">
                <i class="fa fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="rounded-lg bg-white p-6 shadow">
            <form action="{{ route('admin.discounted.update', $property->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Property Info -->
                    <div class="rounded-lg bg-gray-50 p-4">
                        <h3 class="font-medium text-gray-900 mb-3">Informasi Properti</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Judul</p>
                                <p class="font-medium">{{ $property->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Lokasi</p>
                                <p class="font-medium">{{ $property->city ?? 'Belum diisi' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tipe</p>
                                <p class="font-medium">{{ $property->type ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-medium">{{ $property->status ?? 'Dijual' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Price Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga Baru (Rp)
                            </label>
                            <input type="number" name="price" id="price" value="{{ old('price', $property->price) }}" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                                placeholder="Masukkan harga baru">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="original_price" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga Awal (Rp)
                            </label>
                            <input type="number" name="original_price" id="original_price" value="{{ old('original_price', $property->original_price) }}" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                                placeholder="Masukkan harga awal sebelum diskon">
                            @error('original_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Harga asli sebelum diterapkan diskon</p>
                        </div>
                    </div>

                    <!-- Discount Status -->
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_discounted" id="is_discounted" value="1" 
                            {{ old('is_discounted', $property->is_discounted) ? 'checked' : '' }}
                            class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="is_discounted" class="text-sm font-medium text-gray-700">
                            Tandai sebagai properti turun harga
                        </label>
                    </div>

                    @if($property->discounted_at)
                        <div class="text-sm text-gray-500">
                            <i class="fa fa-clock mr-1"></i>
                            Status turun harga sejak: {{ $property->discounted_at->format('d F Y H:i') }}
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex items-center gap-3 pt-4 border-t">
                        <button type="submit" 
                            class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            <i class="fa fa-save mr-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.discounted.index') }}" 
                            class="rounded-lg bg-gray-200 px-6 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-300">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
