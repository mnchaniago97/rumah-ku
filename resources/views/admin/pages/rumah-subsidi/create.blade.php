@extends('admin.layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Tambah Rumah Subsidi</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tambahkan listing rumah subsidi baru.</p>
            </div>
            <a href="{{ route('admin.rumah-subsidi.index') }}" class="text-blue-600 hover:underline">
                <i class="fa fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        @include('admin.pages.rumah-subsidi._form')
    </div>
@endsection

