@extends('frontend.layouts.app')

@section('content')
<div class="bg-gradient-to-br from-blue-700 to-indigo-900 py-16">
    <div class="max-w-[1200px] mx-auto px-4 text-center text-white">
        <h1 class="text-3xl md:text-4xl font-bold mb-4">Proyek Developer Terpercaya</h1>
        <p class="text-lg opacity-90">Temukan proyek properti terbaik dari developer terpercaya di Indonesia</p>
    </div>
</div>

<div class="max-w-[1200px] mx-auto px-4 py-8">
    @if($projects->count() > 0)
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($projects as $project)
                <a href="{{ route('projects.show', $project->slug) }}" class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow group">
                    <div class="aspect-[16/9] bg-gray-200 relative overflow-hidden">
                        @if(!empty($project->images) && count($project->images) > 0)
                            <img src="{{ $project->images[0] }}" 
                                 alt="{{ $project->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @elseif($project->properties->first() && $project->properties->first()->images->first())
                            <img src="{{ Storage::url($project->properties->first()->images->first()->path) }}" 
                                 alt="{{ $project->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-100">
                                <i class="fa fa-building text-4xl text-blue-300"></i>
                            </div>
                        @endif
                        @if($project->logo)
                            <img src="{{ $project->logo }}" alt="Logo" class="absolute bottom-2 right-2 w-10 h-10 rounded-lg bg-white p-1 shadow">
                        @endif
                        @if($project->status === 'active')
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Aktif</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $project->name }}</h4>
                        @if($project->user)
                            <p class="text-sm text-gray-500 mt-1">{{ $project->user->company_name ?? $project->user->name }}</p>
                        @endif
                        <div class="flex items-center justify-between mt-3">
                            <div>
                                @if($project->price_start)
                                    <p class="text-sm font-semibold text-blue-600">
                                        Mulai Rp {{ number_format($project->price_start, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                            <span class="text-xs text-gray-400">
                                <i class="fa fa-home mr-1"></i> {{ $project->properties_count ?? 0 }} Unit
                            </span>
                        </div>
                        @if($project->city)
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="fa fa-map-marker-alt mr-1"></i> {{ $project->city }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $projects->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <i class="fa fa-building text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada proyek tersedia</h3>
            <p class="text-gray-500">Proyek dari developer akan segera hadir</p>
        </div>
    @endif
</div>
@endsection