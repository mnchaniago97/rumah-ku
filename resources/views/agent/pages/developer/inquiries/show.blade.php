@extends('agent.layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Detail Inquiry" />

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Sender Info --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Informasi Pengirim</h4>
                <div class="flex items-start gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-900/20">
                        <i class="fa fa-user text-brand-500 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h5 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $inquiry->name }}</h5>
                        <div class="mt-2 space-y-1">
                            <p class="text-sm text-gray-500">
                                <i class="fa fa-envelope mr-2 w-4"></i>{{ $inquiry->email }}
                            </p>
                            <p class="text-sm text-gray-500">
                                <i class="fa fa-phone mr-2 w-4"></i>{{ $inquiry->phone }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Project Info --}}
            @if($inquiry->project)
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Proyek Terkait</h4>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden">
                        @if($inquiry->project->properties->first() && $inquiry->project->properties->first()->images->first())
                            <img src="{{ Storage::url($inquiry->project->properties->first()->images->first()->path) }}" 
                                 alt="{{ $inquiry->project->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fa fa-building text-gray-300"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h5 class="font-medium text-gray-800 dark:text-white/90">{{ $inquiry->project->name }}</h5>
                        @if($inquiry->project->city)
                            <p class="text-sm text-gray-500">{{ $inquiry->project->city }}</p>
                        @endif
                    </div>
                    <a href="{{ route('agent.developer-projects.show', $inquiry->project->id) }}" 
                       class="ml-auto px-3 py-1.5 text-sm text-brand-500 hover:text-brand-600 hover:bg-gray-50 rounded-lg transition-colors">
                        Lihat Proyek
                    </a>
                </div>
            </div>
            @endif

            {{-- Message --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Pesan</h4>
                @if($inquiry->subject)
                    <h5 class="font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $inquiry->subject }}</h5>
                @endif
                <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $inquiry->message }}</p>
            </div>

            {{-- Additional Info --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Informasi Tambahan</h4>
                <div class="grid grid-cols-2 gap-4">
                    @if($inquiry->property_type_interest)
                        <div>
                            <p class="text-sm text-gray-500">Tipe Properti Diminati</p>
                            <p class="font-medium text-gray-800 dark:text-white/90">{{ $inquiry->property_type_interest }}</p>
                        </div>
                    @endif
                    @if($inquiry->budget_min || $inquiry->budget_max)
                        <div>
                            <p class="text-sm text-gray-500">Budget</p>
                            <p class="font-medium text-gray-800 dark:text-white/90">
                                @if($inquiry->budget_min)
                                    Rp {{ number_format($inquiry->budget_min, 0, ',', '.') }}
                                @endif
                                @if($inquiry->budget_max)
                                    - Rp {{ number_format($inquiry->budget_max, 0, ',', '.') }}
                                @endif
                            </p>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-500">Cara Pembayaran</p>
                        <p class="font-medium text-gray-800 dark:text-white/90">{{ $inquiry->financing_type_label }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kunjungan Lokasi</p>
                        <p class="font-medium text-gray-800 dark:text-white/90">
                            {{ $inquiry->wants_site_visit ? 'Ya' : 'Tidak' }}
                            @if($inquiry->wants_site_visit && $inquiry->preferred_visit_date)
                                ({{ $inquiry->preferred_visit_date->format('d M Y') }})
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Status Update --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Status</h4>
                <form action="{{ route('agent.developer-inquiries.update-status', $inquiry->id) }}" method="POST" id="statusForm">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ubah Status</label>
                            <select name="status" id="statusSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none dark:border-gray-700 dark:bg-gray-800">
                                <option value="new" {{ $inquiry->status === 'new' ? 'selected' : '' }}>Baru</option>
                                <option value="contacted" {{ $inquiry->status === 'contacted' ? 'selected' : '' }}>Dihubungi</option>
                                <option value="qualified" {{ $inquiry->status === 'qualified' ? 'selected' : '' }}>Kualifikasi</option>
                                <option value="closed" {{ $inquiry->status === 'closed' ? 'selected' : '' }}>Selesai</option>
                                <option value="rejected" {{ $inquiry->status === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Internal</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none dark:border-gray-700 dark:bg-gray-800 resize-none">{{ $inquiry->notes }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-brand-500 text-white rounded-lg hover:bg-brand-600 transition-colors">
                            <i class="fa fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Timeline --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Timeline</h4>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                            <i class="fa fa-envelope text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">Inquiry Diterima</p>
                            <p class="text-xs text-gray-500">{{ $inquiry->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if($inquiry->contacted_at)
                        <div class="flex gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                                <i class="fa fa-phone text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">Dihubungi</p>
                                <p class="text-xs text-gray-500">{{ $inquiry->contacted_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 mb-4">Aksi</h4>
                <div class="space-y-3">
                    <a href="mailto:{{ $inquiry->email }}" 
                       class="flex items-center gap-3 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors dark:border-gray-700 dark:hover:bg-gray-800">
                        <i class="fa fa-envelope text-gray-500"></i>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Kirim Email</span>
                    </a>
                    <a href="tel:{{ $inquiry->phone }}" 
                       class="flex items-center gap-3 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors dark:border-gray-700 dark:hover:bg-gray-800">
                        <i class="fa fa-phone text-gray-500"></i>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Telepon</span>
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank"
                       class="flex items-center gap-3 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors dark:border-gray-700 dark:hover:bg-gray-800">
                        <i class="fa fa-whatsapp text-green-500"></i>
                        <span class="text-sm text-gray-700 dark:text-gray-300">WhatsApp</span>
                    </a>
                </div>
            </div>

            {{-- Back Button --}}
            <a href="{{ route('agent.developer-inquiries.index') }}" 
               class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors dark:border-gray-700 dark:hover:bg-gray-800">
                <i class="fa fa-arrow-left"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.getElementById('statusForm').addEventListener('submit', function(e) {
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
            location.reload();
        } else {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
});
</script>
@endpush