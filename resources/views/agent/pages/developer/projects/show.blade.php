@extends('agent.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="{{ $project->name }}" />

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Project Header -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-start gap-4">
                    <div class="h-20 w-20 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center">
                        @if($project->logo)
                            <img src="{{ $project->logo }}" alt="{{ $project->name }}" class="h-full w-full object-cover">
                        @else
                            <i class="fa fa-building text-gray-300 text-3xl"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $project->name }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fa fa-map-marker mr-1"></i>
                                    {{ $project->address ?? '' }}{{ $project->address && $project->city ? ', ' : '' }}{{ $project->city ?? '' }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs {{ match($project->status) {
                                    'active' => 'bg-green-50 text-green-600',
                                    'completed' => 'bg-blue-50 text-blue-600',
                                    'on-hold' => 'bg-yellow-50 text-yellow-600',
                                    'cancelled' => 'bg-red-50 text-red-600',
                                    default => 'bg-gray-50 text-gray-600'
                                } }} rounded-full px-2 py-0.5 font-medium">
                                    {{ ucfirst(str_replace('-', ' ', $project->status ?? 'active')) }}
                                </span>
                                @if($project->is_published)
                                    <span class="rounded-full bg-green-50 px-2 py-0.5 text-xs font-semibold text-green-600">Published</span>
                                @else
                                    <span class="rounded-full bg-gray-50 px-2 py-0.5 text-xs font-semibold text-gray-600">Draft</span>
                                @endif
                            </div>
                        </div>
                        @if($project->price_start)
                            <div class="mt-2 text-lg font-bold text-brand-600">
                                Rp {{ number_format($project->price_start, 0, ',', '.') }}
                                @if($project->price_end)
                                    - Rp {{ number_format($project->price_end, 0, ',', '.') }}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if($project->description)
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $project->description }}</p>
                    </div>
                @endif

                <div class="mt-4 flex items-center gap-4">
                    <a href="{{ route('agent.developer-projects.edit', $project) }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                        <i class="fa fa-edit"></i>
                        Edit Proyek
                    </a>
                    @if($project->brochure)
                        <a href="{{ $project->brochure }}" target="_blank"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            <i class="fa fa-file-pdf"></i>
                            Lihat Brosur
                        </a>
                    @endif
                    @if($project->video_url)
                        <a href="{{ $project->video_url }}" target="_blank"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            <i class="fa fa-video"></i>
                            Lihat Video
                        </a>
                    @endif
                </div>
            </div>

            <!-- Project Images -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Gambar Proyek</h4>
                
                @if(!empty($project->images) && count($project->images) > 0)
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                        @foreach($project->images as $index => $image)
                            <div class="group relative">
                                <div class="aspect-square overflow-hidden rounded-lg bg-gray-100">
                                    <img src="{{ $image }}" alt="Image {{ $index + 1 }}" class="h-full w-full object-cover">
                                </div>
                                <form action="{{ route('agent.developer-projects.images.destroy', [$project, $index]) }}" method="POST" 
                                    onsubmit="return confirm('Hapus gambar ini?')" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-full bg-red-500 text-white shadow-lg hover:bg-red-600">
                                        <i class="fa fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800/50">
                        <i class="fa fa-image mb-2 text-2xl text-gray-300"></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada gambar proyek.</p>
                        <a href="{{ route('agent.developer-projects.edit', $project) }}" class="mt-2 inline-block text-sm text-brand-500 hover:underline">
                            Tambah Gambar
                        </a>
                    </div>
                @endif
            </div>

            <!-- Project Stats -->
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Unit</p>
                    <p class="mt-1 text-xl font-bold text-gray-800 dark:text-white">{{ $project->total_units ?? '-' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Unit Tersedia</p>
                    <p class="mt-1 text-xl font-bold text-green-600">{{ $project->available_units ?? '-' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Tanggal Mulai</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white">{{ $project->start_date?->format('d M Y') ?? '-' }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Tanggal Selesai</p>
                    <p class="mt-1 text-sm font-semibold text-gray-800 dark:text-white">{{ $project->end_date?->format('d M Y') ?? '-' }}</p>
                </div>
            </div>

            <!-- Properties in Project -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Properti dalam Proyek</h4>
                    <button type="button" onclick="openAddPropertyModal()"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-brand-600">
                        <i class="fa fa-plus"></i>
                        Tambah Properti
                    </button>
                </div>
                
                @if($project->properties->count() > 0)
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach($project->properties as $property)
                            <div class="rounded-lg border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/50">
                                <div class="flex items-center gap-3">
                                    <div class="h-16 w-16 overflow-hidden rounded-lg bg-gray-200">
                                        @if($property->images->first())
                                            <img src="{{ $property->images->first()->path }}" alt="{{ $property->title }}" class="h-full w-full object-cover">
                                        @else
                                            <i class="fa fa-home text-gray-300 text-xl flex items-center justify-center h-full"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h5 class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ $property->title }}</h5>
                                        <p class="text-xs text-gray-500">{{ $property->category?->name ?? '-' }}</p>
                                        <p class="text-sm font-bold text-brand-600">Rp {{ number_format($property->price ?? 0, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('agent.properties.show', $property) }}" class="text-brand-500 hover:text-brand-600" title="Lihat Detail">
                                            <i class="fa fa-external-link"></i>
                                        </a>
                                        <form action="{{ route('agent.developer-projects.properties.destroy', [$project, $property->id]) }}" method="POST" 
                                            onsubmit="return confirm('Hapus properti dari proyek ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600" title="Hapus dari Proyek">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center dark:border-gray-700 dark:bg-gray-800/50">
                        <i class="fa fa-home mb-2 text-2xl text-gray-300"></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada properti dalam proyek ini.</p>
                        <button type="button" onclick="openAddPropertyModal()" class="mt-2 inline-block text-sm text-brand-500 hover:underline">
                            Tambah Properti Pertama
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Project Info -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Informasi Proyek</h4>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Kota</dt>
                        <dd class="mt-1 font-medium text-gray-800 dark:text-white">{{ $project->city ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Provinsi</dt>
                        <dd class="mt-1 font-medium text-gray-800 dark:text-white">{{ $project->province ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">Dibuat</dt>
                        <dd class="mt-1 font-medium text-gray-800 dark:text-white">{{ $project->created_at->format('d M Y') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Danger Zone -->
            <div class="rounded-2xl border border-red-200 bg-red-50 p-6 dark:border-red-800 dark:bg-red-900/20">
                <h4 class="mb-4 text-base font-semibold text-red-800 dark:text-red-200">Zona Bahaya</h4>
                <p class="text-sm text-red-600 dark:text-red-300 mb-4">Hapus proyek ini secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                <form action="{{ route('agent.developer-projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full rounded-lg bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                        <i class="fa fa-trash mr-2"></i>
                        Hapus Proyek
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Property Modal -->
    <div id="addPropertyModal" class="fixed inset-0 z-50 hidden">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeAddPropertyModal()"></div>
            <div class="relative w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl dark:bg-gray-800">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Tambah Properti ke Proyek</h3>
                    <button type="button" onclick="closeAddPropertyModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('agent.developer-projects.properties.store', $project) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Properti</label>
                        <select name="property_id" required id="propertySelect"
                            class="h-11 w-full rounded-lg border border-gray-200 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">-- Pilih Properti --</option>
                            @php
                                $availableProperties = \App\Models\Property::where('user_id', auth()->id())
                                    ->whereNotIn('id', $project->properties->pluck('id'))
                                    ->with('category')
                                    ->get();
                            @endphp
                            @foreach($availableProperties as $prop)
                                <option value="{{ $prop->id }}">{{ $prop->title }} ({{ $prop->category?->name ?? '-' }})</option>
                            @endforeach
                        </select>
                        @if($availableProperties->isEmpty())
                            <p class="mt-2 text-xs text-gray-500">
                                Tidak ada properti yang tersedia. 
                                <a href="{{ route('agent.properties.create') }}" class="text-brand-500 hover:underline">Buat properti baru</a>
                            </p>
                        @endif
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeAddPropertyModal()" 
                            class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            Batal
                        </button>
                        <button type="submit" 
                            class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                            Tambah Properti
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function openAddPropertyModal() {
    document.getElementById('addPropertyModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAddPropertyModal() {
    document.getElementById('addPropertyModal').classList.add('hidden');
    document.body.style.overflow = '';
}
</script>
@endpush