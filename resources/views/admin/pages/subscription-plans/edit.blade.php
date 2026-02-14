@extends('admin.layouts.app')

@section('content')
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Paket</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Ubah harga, fitur, akses, dan status paket.</p>
      </div>
      <a href="{{ route('admin.subscription-plans.index', ['type' => $plan->agent_type]) }}"
        class="text-sm font-semibold text-gray-700 hover:underline dark:text-gray-200">Kembali</a>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900">
      <form method="POST" action="{{ route('admin.subscription-plans.update', $plan) }}" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.pages.subscription-plans._form', ['plan' => $plan])

        <div class="flex items-center gap-2">
          <button type="submit" class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-600">
            Simpan
          </button>
          <a href="{{ route('admin.subscription-plans.index', ['type' => $plan->agent_type]) }}"
            class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-white/[0.03]">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection

