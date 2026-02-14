@extends('agent.layouts.app')

@section('content')
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Properti Sewa</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui data listing sewa.</p>
      </div>
      <a href="{{ route('agent.sewa.index') }}" class="text-sm font-semibold text-gray-700 hover:underline dark:text-gray-200">Kembali</a>
    </div>

    @include('agent.pages.sewa._form', ['property' => $property])
  </div>
@endsection

