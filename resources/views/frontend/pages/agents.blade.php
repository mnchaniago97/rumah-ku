@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Cari Agen Properti</h1>
                <p class="mt-2 text-gray-600">Temukan agen properti terpercaya di sekitar Anda</p>
            </div>

            {{-- Search Agent --}}
            <div class="bg-white rounded-xl p-6 shadow-sm mb-10">
                <form method="GET" action="{{ route('agents') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari berdasarkan nama, email, atau telepon..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="city" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kota</option>
                            @foreach(($cityOptions ?? collect()) as $cityOption)
                                <option value="{{ $cityOption }}" @selected(($filters['city'] ?? '') === $cityOption)>
                                    {{ $cityOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                        <i class="fa fa-search mr-2"></i>Cari
                    </button>
                </form>
            </div>

            {{-- Top Agents --}}
            <h3 class="text-xl font-bold text-gray-900 mb-6">Agen Pilihan</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                @forelse(($topAgents ?? collect()) as $agent)
                    @php
                        $avatar = $agent->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($agent->name) . '&background=random&color=fff&size=256';
                        $phone = preg_replace('/[^0-9]/', '', (string) ($agent->whatsapp_phone ?? $agent->phone ?? ''));
                        $wa = $phone ? 'https://wa.me/' . $phone : null;
                    @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm text-center hover:shadow-md transition">
                        <div class="w-20 h-20 rounded-full bg-gray-200 mx-auto mb-4 overflow-hidden">
                            <img src="{{ $avatar }}" alt="{{ $agent->name }}" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <div class="flex items-center justify-center gap-2">
                            <h4 class="font-semibold text-gray-900">{{ $agent->name }}</h4>
                            @if(!empty($agent->agent_verified_at))
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">
                                    <i class="fa fa-circle-check"></i>
                                    Verified
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mb-3">{{ $agent->published_properties_count ?? 0 }} properti aktif</p>
                        <div class="flex items-center justify-center gap-1 mb-4">
                            <span class="text-xs text-gray-500">Agen terdaftar</span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('agents.show', $agent) }}"
                                class="flex-1 px-3 py-2 border border-gray-300 text-gray-700 text-sm rounded-lg hover:bg-gray-50 transition">
                                Lihat Profil
                            </a>
                            <a @if($wa) href="{{ $wa }}" target="_blank" rel="noopener" @else aria-disabled="true" @endif
                                class="flex-1 px-3 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition flex items-center justify-center gap-1 {{ $wa ? '' : 'opacity-50 pointer-events-none' }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-xl border border-dashed border-gray-200 bg-white p-6 text-center text-sm text-gray-500">
                        Belum ada agent terdaftar.
                    </div>
                @endforelse
            </div>

            {{-- All Agents List --}}
            <h3 class="text-xl font-bold text-gray-900 mb-6">Semua Agen</h3>
            <div class="space-y-4">
                @forelse($agents as $agent)
                    @php
                        $avatar = $agent->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($agent->name) . '&background=random&color=fff&size=256';
                        $phone = preg_replace('/[^0-9]/', '', (string) ($agent->whatsapp_phone ?? $agent->phone ?? ''));
                        $wa = $phone ? 'https://wa.me/' . $phone : null;
                    @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm flex flex-col md:flex-row items-center gap-4 hover:shadow-md transition">
                        <div class="flex items-center gap-4 flex-1">
                            <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                                <img src="{{ $avatar }}" alt="{{ $agent->name }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-semibold text-gray-900">{{ $agent->name }}</h4>
                                    @if(!empty($agent->agent_verified_at))
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">
                                            <i class="fa fa-circle-check"></i>
                                            Verified
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500">Agen terdaftar</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $agent->published_properties_count ?? 0 }} properti aktif</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex gap-2">
                                <a href="{{ route('agents.show', $agent) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">
                                    Lihat Profil
                                </a>
                                <a @if($wa) href="{{ $wa }}" target="_blank" rel="noopener" @else aria-disabled="true" @endif
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition {{ $wa ? '' : 'opacity-50 pointer-events-none' }}">
                                    Hubungi (WA)
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-200 bg-white p-6 text-center text-sm text-gray-500">
                        Tidak ada agent yang cocok dengan filter.
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-10 flex justify-center">
                {{ $agents->links() }}
            </div>
        </div>
    </div>
@endsection
