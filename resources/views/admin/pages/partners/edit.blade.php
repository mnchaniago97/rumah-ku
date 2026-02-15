@extends('admin.layouts.app')

@section('title', 'Edit Partner')

@section('content')
  <div class="w-full max-w-3xl">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Edit Partner</h1>
      <a href="{{ route('admin.partners.index', ['type' => $partner->type]) }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">
        Kembali
      </a>
    </div>

    @if(session('success'))
      <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        <div class="font-semibold mb-1">Periksa kembali input Anda:</div>
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
      @csrf
      @method('PUT')

      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
          <select name="type" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @foreach(($types ?? []) as $k => $label)
              <option value="{{ $k }}" @selected(old('type', $partner->type) === $k)>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', $partner->sort_order) }}" min="0" max="9999"
            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" name="name" value="{{ old('name', $partner->name) }}" required
          class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div class="mt-4 grid gap-4 md:grid-cols-2">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Website (opsional)</label>
          <input type="url" name="website_url" value="{{ old('website_url', $partner->website_url) }}"
            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://...">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Logo (opsional)</label>
          <input type="file" name="logo" accept="image/*"
            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 bg-white focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
          @if($partner->logo)
            <div class="mt-2 flex items-center gap-3">
              <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}" class="h-12 w-12 rounded bg-white object-contain ring-1 ring-gray-200">
              <div class="text-xs text-gray-500">Logo saat ini</div>
            </div>
          @endif
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
        <textarea name="description" rows="3"
          class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $partner->description) }}</textarea>
      </div>

      <div class="mt-4 flex flex-wrap items-center gap-6">
        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
          <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-blue-600" @checked(old('is_active', $partner->is_active))>
          Aktif
        </label>
        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
          <input type="checkbox" name="is_kpr" value="1" class="rounded border-gray-300 text-blue-600" @checked(old('is_kpr', $partner->is_kpr))>
          (Khusus Bank) Partner KPR
        </label>
      </div>

      <div class="mt-6 flex items-center justify-end gap-3">
        <a href="{{ route('admin.partners.index', ['type' => $partner->type]) }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">
          Batal
        </a>
        <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
@endsection

