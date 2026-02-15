@extends('admin.layouts.app')

@section('title', 'Detail Pesan')

@section('content')
  <div class="w-full max-w-4xl">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesan</h1>
        <p class="text-sm text-gray-500 mt-1">
          {{ $message->created_at?->format('d M Y H:i') }} ·
          <span class="font-semibold {{ $message->is_read ? 'text-gray-600' : 'text-amber-700' }}">{{ $message->is_read ? 'Dibaca' : 'Baru' }}</span>
        </p>
      </div>
      <div class="flex items-center gap-2">
        <a href="{{ route('admin.contact-messages.index') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-semibold text-gray-700 hover:bg-gray-50">
          Kembali
        </a>
        @if($message->is_read)
          <form action="{{ route('admin.contact-messages.unread', $message) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-4 py-2 rounded-lg border border-amber-200 bg-amber-50 text-sm font-semibold text-amber-800 hover:bg-amber-100">
              Tandai belum dibaca
            </button>
          </form>
        @else
          <form action="{{ route('admin.contact-messages.read', $message) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-4 py-2 rounded-lg border border-emerald-200 bg-emerald-50 text-sm font-semibold text-emerald-800 hover:bg-emerald-100">
              Tandai dibaca
            </button>
          </form>
        @endif
        <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-4 py-2 rounded-lg border border-red-200 bg-red-50 text-sm font-semibold text-red-700 hover:bg-red-100">
            Hapus
          </button>
        </form>
      </div>
    </div>

    @if(session('success'))
      <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
      </div>
    @endif

    <div class="grid gap-6 md:grid-cols-3">
      <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800">Pesan</h2>
        <div class="mt-4 rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm text-gray-800 whitespace-pre-wrap">{{ $message->message }}</div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800">Pengirim</h2>

        <dl class="mt-4 space-y-3 text-sm">
          <div>
            <dt class="text-gray-500">Nama</dt>
            <dd class="font-semibold text-gray-800">{{ $message->name }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Email</dt>
            <dd>
              <a href="mailto:{{ $message->email }}" class="font-semibold text-blue-700 hover:underline">{{ $message->email }}</a>
            </dd>
          </div>
          <div>
            <dt class="text-gray-500">Telepon/WhatsApp</dt>
            <dd class="font-semibold text-gray-800">{{ $message->phone }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Subjek</dt>
            <dd class="font-semibold text-gray-800">{{ $message->subject ?: '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">IP</dt>
            <dd class="font-semibold text-gray-800">{{ $message->ip ?: '-' }}</dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
@endsection

