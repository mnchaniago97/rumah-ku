@extends('frontend.layouts.app')

@section('content')
    @php
        $contact = \App\Support\SiteSettings::contact();
        $phone = $contact['phone'] ?? '';
        $phoneTel = preg_replace('/\\D+/', '', $phone);
        $waText = $contact['whatsapp'] ?? '';
        $waLink = $contact['whatsapp_link'] ?? '';
        $email = $contact['email'] ?? '';

        $mapsQuery = $contact['maps_query'] ?? ($contact['address'] ?? '');
        $mapsQuery = is_string($mapsQuery) ? trim($mapsQuery) : '';
        if (!filled($mapsQuery)) {
            $mapsQuery = 'Jakarta, Indonesia';
        }
        $mapsUrl = 'https://www.google.com/maps?q=' . urlencode($mapsQuery) . '&output=embed';
    @endphp
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">{{ $contact['title'] ?? 'Hubungi Kami' }}</h1>
                <p class="mt-2 text-gray-600">{{ $contact['subtitle'] ?? '' }}</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa fa-phone text-xl text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Telepon</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        @if(filled($phone))
                            <a href="tel:{{ $phoneTel }}" class="hover:text-blue-600">{{ $phone }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa fa-whatsapp text-xl text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">WhatsApp</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        @if(filled($waText) && filled($waLink))
                            <a href="{{ $waLink }}" class="hover:text-green-600">{{ $waText }}</a>
                        @elseif(filled($waText))
                            <span>{{ $waText }}</span>
                        @else
                            <span>-</span>
                        @endif
                    </p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm text-center">
                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa fa-envelope text-xl text-red-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Email</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        @if(filled($email))
                            <a href="mailto:{{ $email }}" class="hover:text-red-600">{{ $email }}</a>
                        @else
                            <span>-</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Kirim Pesan</h2>

                    @if(session('success'))
                        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                            <div class="font-semibold mb-1">Periksa kembali input Anda:</div>
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama lengkap">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="email@anda.com">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Telepon/WhatsApp</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0812-3456-7890">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                            <select name="subject" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih subjek...</option>
                                <option value="informasi" @selected(old('subject') === 'informasi')>Informasi Properti</option>
                                <option value="iklan" @selected(old('subject') === 'iklan')>Pasang Iklan</option>
                                <option value="kerjasama" @selected(old('subject') === 'kerjasama')>Kerjasama</option>
                                <option value="lainnya" @selected(old('subject') === 'lainnya')>Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea name="message" rows="4" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tulis pesan Anda...">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="w-full rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700 transition">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Lokasi Kantor</h2>
                    @if(filled($contact['maps_embed_html'] ?? null))
                        <div class="aspect-video overflow-hidden rounded-lg mb-4 bg-gray-100">
                            {!! $contact['maps_embed_html'] !!}
                        </div>
                    @else
                        <div class="aspect-video overflow-hidden rounded-lg mb-4 bg-gray-100">
                            <iframe
                                title="Google Maps"
                                src="{{ $mapsUrl }}"
                                width="100%"
                                height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        </div>
                    @endif
                    <div class="space-y-3 text-sm text-gray-600">
                        <p class="flex items-start gap-3">
                            <i class="fa fa-map-marker mt-1 text-red-500"></i>
                            <span>{{ $contact['address'] ?? '-' }}</span>
                        </p>
                        <p class="flex items-center gap-3">
                            <i class="fa fa-clock-o text-blue-500"></i>
                            <span>{{ $contact['hours'] ?? '-' }}</span>
                        </p>
                        <p class="flex items-center gap-3">
                            <i class="fa fa-calendar text-green-500"></i>
                            <span>{{ $contact['notes'] ?? '-' }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
