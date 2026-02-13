@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.sewa.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Properti Sewa</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Edit properti sewa yang sudah ada.</p>
        </div>

        @include('admin.pages.sewa._form')
    </div>
@endsection
