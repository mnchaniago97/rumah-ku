@extends('admin.layouts.app')

@section('title', 'Pesan Kontak')

@section('content')
  @php
    $currentFilter = $filter ?? 'unread';
  @endphp

  <div class="w-full">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Pesan Kontak</h1>
        <p class="text-sm text-gray-500 mt-1">Pesan dari form "Kirim Pesan" di halaman Contact.</p>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('admin.contact-messages.index', ['filter' => 'unread']) }}"
          class="px-4 py-2 rounded-lg border text-sm font-semibold transition {{ $currentFilter === 'unread' ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
          Belum dibaca ({{ $unreadCount ?? 0 }})
        </a>
        <a href="{{ route('admin.contact-messages.index', ['filter' => 'all']) }}"
          class="px-4 py-2 rounded-lg border text-sm font-semibold transition {{ $currentFilter === 'all' ? 'border-blue-600 text-blue-700 bg-blue-50' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
          Semua
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

    <div class="w-full bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kontak</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Subjek</th>
              <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Waktu</th>
              <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @forelse($messages as $m)
              <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3">
                  <span class="px-2 py-1 text-xs rounded-full {{ $m->is_read ? 'bg-gray-100 text-gray-600' : 'bg-amber-100 text-amber-700' }}">
                    {{ $m->is_read ? 'Dibaca' : 'Baru' }}
                  </span>
                </td>
                <td class="px-4 py-3">
                  <div class="text-sm font-semibold text-gray-800">{{ $m->name }}</div>
                  <div class="text-xs text-gray-500">{{ $m->email }}</div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700">
                  {{ $m->phone }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-700">
                  {{ $m->subject ?: '-' }}
                </td>
                <td class="px-4 py-3 text-sm text-gray-600">
                  {{ $m->created_at?->diffForHumans() }}
                </td>
                <td class="px-4 py-3 text-right">
                  <div class="inline-flex items-center gap-2">
                    <a href="{{ route('admin.contact-messages.show', $m) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Buka">
                      <i class="fas fa-eye"></i>
                    </a>
                    @if($m->is_read)
                      <form action="{{ route('admin.contact-messages.unread', $m) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="p-2 text-amber-700 hover:bg-amber-50 rounded-lg transition" title="Tandai belum dibaca">
                          <i class="fas fa-envelope"></i>
                        </button>
                      </form>
                    @else
                      <form action="{{ route('admin.contact-messages.read', $m) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="p-2 text-emerald-700 hover:bg-emerald-50 rounded-lg transition" title="Tandai dibaca">
                          <i class="fas fa-check"></i>
                        </button>
                      </form>
                    @endif
                    <form action="{{ route('admin.contact-messages.destroy', $m) }}" method="POST"
                      onsubmit="return confirm('Hapus pesan ini?')">
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
                <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                  <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                  <p>Belum ada pesan.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($messages->hasPages())
        <div class="px-4 py-3 border-t">
          {{ $messages->links() }}
        </div>
      @endif
    </div>
  </div>
@endsection

