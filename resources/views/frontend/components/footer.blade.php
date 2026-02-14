@php
    $footer = \App\Support\SiteSettings::footer();
    $contact = \App\Support\SiteSettings::contact();

    $socials = $footer['socials'] ?? [];
    $quickLinks = $footer['quick_links'] ?? [];
    $legalLinks = $footer['legal_links'] ?? [];

    $footerContact = [
        'address' => $footer['contact']['address'] ?? ($contact['address'] ?? null),
        'phone' => $footer['contact']['phone'] ?? ($contact['phone'] ?? null),
        'email' => $footer['contact']['email'] ?? ($contact['email'] ?? null),
        'whatsapp' => $footer['contact']['whatsapp'] ?? ($contact['whatsapp'] ?? null),
    ];
@endphp

<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-[1200px] mx-auto px-4 py-12">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            <!-- About -->
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-xl font-bold text-white">{{ $footer['brand'] ?? 'Rumah IO' }}</h3>
                <p class="mt-4 text-sm text-gray-400">
                    {{ $footer['description'] ?? '' }}
                </p>

                <div class="mt-6">
                    <p class="text-sm font-medium text-white mb-3">Ikuti Kami</p>
                    <div class="flex space-x-3">
                        @php
                            $socialMeta = [
                                'facebook' => ['icon' => 'fab fa-facebook-f', 'hover' => 'hover:bg-blue-600'],
                                'instagram' => ['icon' => 'fab fa-instagram', 'hover' => 'hover:bg-pink-600'],
                                'twitter' => ['icon' => 'fab fa-twitter', 'hover' => 'hover:bg-sky-500'],
                                'youtube' => ['icon' => 'fab fa-youtube', 'hover' => 'hover:bg-red-600'],
                                'linkedin' => ['icon' => 'fab fa-linkedin-in', 'hover' => 'hover:bg-blue-700'],
                                'whatsapp' => ['icon' => 'fab fa-whatsapp', 'hover' => 'hover:bg-green-500'],
                            ];
                        @endphp

                        @foreach($socialMeta as $key => $meta)
                            @php $url = $socials[$key] ?? null; @endphp
                            @if(filled($url))
                                <a href="{{ $url }}" target="_blank" rel="noopener"
                                    class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 {{ $meta['hover'] }} hover:text-white transition duration-300">
                                    <i class="{{ $meta['icon'] }} text-lg"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Tautan Cepat</h4>
                <ul class="mt-4 space-y-2">
                    @foreach(($quickLinks ?? []) as $row)
                        @if(filled($row['label'] ?? null) && filled($row['url'] ?? null))
                            <li>
                                <a href="{{ $row['url'] }}" class="text-sm text-gray-400 hover:text-white transition duration-200">
                                    {{ $row['label'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Hubungi Kami</h4>
                <ul class="mt-4 space-y-3 text-sm">
                    @if(filled($footerContact['address'] ?? null))
                        <li class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-blue-500"></i>
                            </div>
                            <span class="text-gray-400">{{ $footerContact['address'] }}</span>
                        </li>
                    @endif
                    @if(filled($footerContact['phone'] ?? null))
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone-alt text-green-500"></i>
                            </div>
                            <span class="text-gray-400">{{ $footerContact['phone'] }}</span>
                        </li>
                    @endif
                    @if(filled($footerContact['email'] ?? null))
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-yellow-500"></i>
                            </div>
                            <span class="text-gray-400">{{ $footerContact['email'] }}</span>
                        </li>
                    @endif
                    @if(filled($footerContact['whatsapp'] ?? null))
                        <li class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0">
                                <i class="fab fa-whatsapp text-green-500"></i>
                            </div>
                            <span class="text-gray-400">{{ $footerContact['whatsapp'] }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-12 border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400">{{ $footer['copyright'] ?? '' }}</p>
                <div class="flex gap-6 text-sm">
                    @foreach(($legalLinks ?? []) as $row)
                        @if(filled($row['label'] ?? null) && filled($row['url'] ?? null))
                            <a href="{{ $row['url'] }}" class="text-gray-400 hover:text-white transition duration-200">
                                {{ $row['label'] }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</footer>
