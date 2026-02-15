@extends('admin.layouts.app')

@section('title', 'Partner')

@section('content')
  @php
    $types = [
        \App\Models\Partner::TYPE_BANK => 'Bank',
        \App\Models\Partner::TYPE_DEVELOPER => 'Developer',
        \App\Models\Partner::TYPE_AGENT => 'Agen',
        \App\Models\Partner::TYPE_OTHER => 'Lainnya',
    ];
    $currentType = $type ?? \App\Models\Partner::TYPE_BANK;
  @endphp

  <div class="w-full">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Partner</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola partner untuk halaman Perusahaan → Partner.</p>
      </div>
      <a href="{{ route('admin.partners.create', ['type' => $currentType]) }}"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-plus mr-2"></i>Tambah Partner
      </a>
    </div>

    @if(session('success'))
      <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

    <div class="mb-6 border-b border-gray-200">
      <nav class="flex flex-wrap gap-6" aria-label="Tabs">
        @foreach($types as $k => $label)
          <a href="{{ route('admin.partners.index', ['type' => $k]) }}"
            class="py-4 px-1 border-b-2 font-medium text-sm transition {{ $currentType === $k ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            {{ $label }}
          </a>
        @endforeach
      </nav>
    </div>

    <div class="w-full bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Logo</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">KPR</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Urutan</th>
              <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @forelse($partners as $idx => $partner)
              <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 text-sm text-gray-600">{{ $idx + $partners->firstItem() }}</td>
                <td class="px-4 py-3">
                  @if($partner->logo)
                    <img src="{{ Storage::url($partner->logo) }}" alt="{{ $partner->name }}" class="h-10 w-10 rounded bg-white object-contain ring-1 ring-gray-200">
                  @else
                    <div class="h-10 w-10 rounded bg-gray-100 ring-1 ring-gray-200 flex items-center justify-center text-xs text-gray-400">
                      <i class="fas fa-image"></i>
                    </div>
                  @endif
                </td>
                <td class="px-4 py-3">
                  <div class="text-sm font-semibold text-gray-800">{{ $partner->name }}</div>
                  @if($partner->website_url)
                    <a href="{{ $partner->website_url }}" target="_blank" rel="noopener" class="text-xs text-blue-600 hover:underline">
                      {{ $partner->website_url }}
                    </a>
                  @endif
                </td>
                <td class="px-4 py-3">
                  @if($partner->type === \App\Models\Partner::TYPE_BANK)
                    <span class="px-2 py-1 text-xs rounded-full {{ $partner->is_kpr ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                      {{ $partner->is_kpr ? 'Ya' : 'Tidak' }}
                    </span>
                  @else
                    <span class="text-xs text-gray-400">-</span>
                  @endif
                </td>
                <td class="px-4 py-3">
                  <span class="px-2 py-1 text-xs rounded-full {{ $partner->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ $partner->is_active ? 'Aktif' : 'Nonaktif' }}
                  </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-600">{{ $partner->sort_order }}</td>
                <td class="px-4 py-3 text-right">
                  <div class="inline-flex items-center gap-2">
                    <a href="{{ route('admin.partners.edit', $partner) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST"
                      onsubmit="return confirm('Hapus partner ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                  <i class="fas fa-handshake text-4xl mb-3 text-gray-300"></i>
                  <p>Belum ada partner. Tambahkan partner pertama Anda.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($partners->hasPages())
        <div class="px-4 py-3 border-t">
          {{ $partners->links() }}
        </div>
      @endif
    </div>
  </div>
@endsection

