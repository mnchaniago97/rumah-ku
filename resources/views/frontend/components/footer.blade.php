<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-[1200px] mx-auto px-4 py-12">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
            <!-- About -->
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-xl font-bold text-white">Rumah Ku</h3>
                <p class="mt-4 text-sm text-gray-400">
                    Rumah Ku adalah platform properti terpercaya yang membantu Anda menemukan rumah impian dengan mudah dan aman. Kami menyediakan berbagai pilihan properti dari seluruh Indonesia.
                </p>
                
                <!-- Social Media Icons with Tailwind -->
                <div class="mt-6">
                    <p class="text-sm font-medium text-white mb-3">Ikuti Kami</p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition duration-300">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-pink-600 hover:text-white transition duration-300">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-sky-500 hover:text-white transition duration-300">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition duration-300">
                            <i class="fab fa-youtube text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-blue-700 hover:text-white transition duration-300">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-green-500 hover:text-white transition duration-300">
                            <i class="fab fa-whatsapp text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Tautan Cepat</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('properties') }}" class="text-sm text-gray-400 hover:text-white transition duration-200">Properti</a></li>
                    <li><a href="{{ route('projects') }}" class="text-sm text-gray-400 hover:text-white transition duration-200">Proyek</a></li>
                    <li><a href="{{ route('agents') }}" class="text-sm text-gray-400 hover:text-white transition duration-200">Agen</a></li>
                    <li><a href="{{ route('articles') }}" class="text-sm text-gray-400 hover:text-white transition duration-200">Artikel</a></li>
                    <li><a href="{{ route('about') }}" class="text-sm text-gray-400 hover:text-white transition duration-200">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm text-gray-400 hover:text-white transition duration-200">Kontak</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Hubungi Kami</h4>
                <ul class="mt-4 space-y-3 text-sm">
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-blue-500"></i>
                        </div>
                        <span class="text-gray-400">Jl. Sudirman No. 123, Jakarta Pusat 10220</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone-alt text-green-500"></i>
                        </div>
                        <span class="text-gray-400">+62 21 1234 5678</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-yellow-500"></i>
                        </div>
                        <span class="text-gray-400">info@rumahku.com</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-green-500"></i>
                        </div>
                        <span class="text-gray-400">+62 812 3456 7890</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-12 border-t border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400">&copy; 2026 Rumah Ku. All rights reserved.</p>
                <div class="flex gap-6 text-sm">
                    <a href="#" class="text-gray-400 hover:text-white transition duration-200">Kebijakan Privasi</a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-200">Syarat & Ketentuan</a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-200">Peta Situs</a>
                </div>
            </div>
        </div>
    </div>
</footer>
