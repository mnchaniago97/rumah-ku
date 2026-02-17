@extends('frontend.layouts.app')

@section('content')
<div class="bg-gradient-to-br from-blue-700 to-indigo-900 py-12">
    <div class="max-w-[1200px] mx-auto px-4">
        <nav class="text-sm text-white/70 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('projects') }}" class="hover:text-white">Proyek</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $project->name }}</span>
        </nav>
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $project->name }}</h1>
                @if($project->user)
                    <p class="text-white/80">
                        <i class="fa fa-building mr-2"></i>{{ $project->user->company_name ?? $project->user->name }}
                    </p>
                @endif
                @if($project->address)
                    <p class="text-white/70 mt-2">
                        <i class="fa fa-map-marker-alt mr-2"></i>{{ $project->address }}
                        @if($project->city), {{ $project->city }}@endif
                    </p>
                @endif
            </div>
            @if($project->logo)
                <img src="{{ $project->logo }}" alt="Logo" class="w-16 h-16 rounded-lg bg-white p-2 shadow">
            @endif
        </div>
    </div>
</div>

<div class="max-w-[1200px] mx-auto px-4 py-8">
    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            {{-- Project Images --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                @if(!empty($project->images) && count($project->images) > 0)
                    {{-- Main Image --}}
                    <div class="aspect-[16/9] bg-gray-200 relative">
                        <img id="mainImage" src="{{ $project->images[0] }}" 
                             alt="{{ $project->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    @if(count($project->images) > 1)
                        {{-- Thumbnail Gallery --}}
                        <div class="p-4 flex gap-2 overflow-x-auto">
                            @foreach($project->images as $index => $image)
                                <button type="button" onclick="changeMainImage('{{ $image }}')"
                                    class="flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-blue-500' : 'border-gray-200' }} hover:border-blue-400 transition-colors">
                                    <img src="{{ $image }}" alt="Image {{ $index + 1 }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                @elseif($project->properties->first() && $project->properties->first()->images->first())
                    <div class="aspect-[16/9] bg-gray-200">
                        <img src="{{ $project->properties->first()->images->first()->path }}" 
                             alt="{{ $project->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="aspect-[16/9] bg-gray-200 flex items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-100">
                        <i class="fa fa-building text-6xl text-blue-300"></i>
                    </div>
                @endif
            </div>

            {{-- Project Info --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Tentang Proyek</h2>
                @if($project->description)
                    <div class="prose prose-sm max-w-none text-gray-600">
                        {{ $project->description }}
                    </div>
                @else
                    <p class="text-gray-500">Tidak ada deskripsi proyek.</p>
                @endif
            </div>

            {{-- Project Details --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Proyek</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fa fa-home text-2xl text-blue-500 mb-2"></i>
                        <p class="text-2xl font-bold text-gray-800">{{ $project->properties_count ?? 0 }}</p>
                        <p class="text-sm text-gray-500">Unit Tersedia</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fa fa-calendar text-2xl text-green-500 mb-2"></i>
                        <p class="text-sm font-semibold text-gray-800">{{ $project->status === 'active' ? 'Aktif' : 'Non-Aktif' }}</p>
                        <p class="text-sm text-gray-500">Status</p>
                    </div>
                    @if($project->price_start)
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <i class="fa fa-tag text-2xl text-orange-500 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-800">Mulai</p>
                            <p class="text-sm text-gray-500">Rp {{ number_format($project->price_start, 0, ',', '.') }}</p>
                        </div>
                    @endif
                    @if($project->price_end)
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <i class="fa fa-tags text-2xl text-purple-500 mb-2"></i>
                            <p class="text-sm font-semibold text-gray-800">Sampai</p>
                            <p class="text-sm text-gray-500">Rp {{ number_format($project->price_end, 0, ',', '.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Properties in Project --}}
            @if($project->properties->count() > 0)
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Unit Tersedia ({{ $project->properties->count() }})</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($project->properties->take(6) as $property)
                        <a href="{{ route('property.show', $property->slug) }}" class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow group">
                            <div class="aspect-[4/3] bg-gray-200">
                                @if($property->images->first())
                                    <img src="{{ $property->images->first()->path }}" 
                                         alt="{{ $property->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                        <i class="fa fa-home text-3xl text-gray-300"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h4 class="font-medium text-gray-800 group-hover:text-blue-600 transition-colors text-sm">{{ $property->title }}</h4>
                                <p class="text-blue-600 font-semibold text-sm mt-1">Rp {{ number_format($property->price, 0, ',', '.') }}</p>
                                @if($property->category)
                                    <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded mt-1">{{ $property->category->name }}</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
                @if($project->properties->count() > 6)
                    <p class="text-center text-gray-500 text-sm mt-4">Dan {{ $project->properties->count() - 6 }} unit lainnya...</p>
                @endif
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            {{-- Inquiry CTA --}}
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white mb-6 sticky top-4">
                <h3 class="text-lg font-semibold mb-2">Tertarik dengan proyek ini?</h3>
                <p class="text-sm text-white/80 mb-4">Hubungi developer untuk informasi lebih lanjut</p>
                <button type="button" 
                        onclick="openInquiryModal()"
                        class="w-full bg-white text-blue-600 font-semibold py-3 px-4 rounded-lg hover:bg-blue-50 transition-colors">
                    <i class="fa fa-envelope mr-2"></i>Kirim Inquiry
                </button>
                @if($project->user && $project->user->phone)
                    <a href="tel:{{ $project->user->phone }}" 
                       class="block w-full bg-white/10 text-white font-semibold py-3 px-4 rounded-lg hover:bg-white/20 transition-colors text-center mt-3">
                        <i class="fa fa-phone mr-2"></i>Hubungi Langsung
                    </a>
                @endif
            </div>

            {{-- Developer Info --}}
            @if($project->user)
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Developer</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        @if($project->user->avatar)
                            <img src="{{ $project->user->avatar }}" alt="{{ $project->user->name }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <i class="fa fa-building text-blue-500"></i>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ $project->user->company_name ?? $project->user->name }}</h4>
                        <p class="text-sm text-gray-500">Developer</p>
                    </div>
                </div>
                @if($project->user->phone)
                    <p class="text-sm text-gray-600 mb-2">
                        <i class="fa fa-phone mr-2 text-gray-400"></i>{{ $project->user->phone }}
                    </p>
                @endif
                @if($project->user->email)
                    <p class="text-sm text-gray-600">
                        <i class="fa fa-envelope mr-2 text-gray-400"></i>{{ $project->user->email }}
                    </p>
                @endif
            </div>
            @endif

            {{-- Similar Projects --}}
            @if($similarProjects->count() > 0)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Proyek Lain dari Developer</h3>
                <div class="space-y-4">
                    @foreach($similarProjects as $similarProject)
                        <a href="{{ route('projects.show', $similarProject->slug) }}" class="block group">
                            <div class="flex gap-3">
                                <div class="w-20 h-16 rounded-lg bg-gray-200 overflow-hidden flex-shrink-0">
                                    @if($similarProject->properties->first() && $similarProject->properties->first()->images->first())
                                        <img src="{{ Storage::url($similarProject->properties->first()->images->first()->path) }}" 
                                             alt="{{ $similarProject->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <i class="fa fa-building text-gray-300"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 group-hover:text-blue-600 transition-colors text-sm">{{ $similarProject->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $similarProject->properties_count ?? 0 }} Unit</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Inquiry Modal --}}
<div id="inquiryModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800">Kirim Inquiry</h3>
                <button type="button" onclick="closeInquiryModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa fa-times text-xl"></i>
                </button>
            </div>
            <p class="text-sm text-gray-500 mt-1">Inquiry akan dikirim ke developer proyek</p>
        </div>
        
        <form id="inquiryForm" action="{{ route('projects.inquiry', $project->slug) }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="Masukkan nama lengkap">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="email@contoh.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Properti yang Diminati</label>
                    <select name="property_type_interest"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value="">Pilih tipe properti</option>
                        <option value="rumah">Rumah</option>
                        <option value="rumah-subsidi">Rumah Subsidi</option>
                        <option value="apartemen">Apartemen</option>
                        <option value="ruko">Ruko</option>
                        <option value="tanah">Tanah</option>
                        <option value="villa">Villa</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Budget Min</label>
                        <input type="number" name="budget_min"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Budget Max</label>
                        <input type="number" name="budget_max"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                               placeholder="0">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cara Pembayaran</label>
                    <select name="financing_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value="cash">Tunai</option>
                        <option value="kpr">KPR</option>
                        <option value="installment">Cicilan</option>
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="wants_site_visit" id="wants_site_visit" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="wants_site_visit" class="text-sm text-gray-700">Saya ingin kunjungan lokasi</label>
                </div>

                <div id="visitDateField" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kunjungan yang Diinginkan</label>
                    <input type="date" name="preferred_visit_date"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan <span class="text-red-500">*</span></label>
                    <textarea name="message" rows="4" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none"
                              placeholder="Tuliskan pesan atau pertanyaan Anda..."></textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="button" onclick="closeInquiryModal()" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fa fa-paper-plane mr-2"></i>Kirim Inquiry
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openInquiryModal() {
    document.getElementById('inquiryModal').classList.remove('hidden');
    document.getElementById('inquiryModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeInquiryModal() {
    document.getElementById('inquiryModal').classList.add('hidden');
    document.getElementById('inquiryModal').classList.remove('flex');
    document.body.style.overflow = '';
}

// Change main image in gallery
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
    // Update thumbnail borders
    document.querySelectorAll('.flex button').forEach(btn => {
        btn.classList.remove('border-blue-500');
        btn.classList.add('border-gray-200');
    });
    event.target.closest('button').classList.remove('border-gray-200');
    event.target.closest('button').classList.add('border-blue-500');
}

// Toggle visit date field
document.getElementById('wants_site_visit').addEventListener('change', function() {
    document.getElementById('visitDateField').classList.toggle('hidden', !this.checked);
});

// Close modal on backdrop click
document.getElementById('inquiryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInquiryModal();
    }
});

// Handle form submission
document.getElementById('inquiryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeInquiryModal();
            form.reset();
        } else {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
});

// Show success message if exists
@if(session('success'))
    alert('{{ session('success') }}');
@endif
</script>
@endpush
@endsection