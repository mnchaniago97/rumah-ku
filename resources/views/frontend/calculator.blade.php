@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Kalkulator KPR</h1>
                <p class="mt-2 text-gray-600">Hitung estimasi cicilan rumah tangga Anda</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                {{-- Calculator Form --}}
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Simulasi KPR</h2>
                    
                    <form id="kpr-form">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga Properti (Rp)</label>
                            <input type="number" id="property-price" value="500000000" step="1000000" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="range" id="price-range" min="100000000" max="5000000000" value="500000000" step="10000000" 
                                class="w-full mt-2 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Uang Muka (%)</label>
                            <div class="flex items-center gap-4">
                                <input type="number" id="down-payment-percent" value="20" min="0" max="100" 
                                    class="w-24 rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <span class="text-gray-600">=</span>
                                <span id="down-payment-amount" class="text-lg font-semibold text-blue-600">Rp 100.000.000</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tenor (Tahun)</label>
                            <div class="grid grid-cols-5 gap-2">
                                @for($tenor = 5; $tenor <= 25; $tenor += 5)
                                    <button type="button" class="tenor-btn py-2 px-3 rounded-lg border text-sm font-medium transition
                                        {{ $tenor == 20 ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}"
                                        data-tenor="{{ $tenor }}">
                                        {{ $tenor }}
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Suku Bunga (%)</label>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach([6.5, 7, 8, 9] as $rate)
                                    <button type="button" class="rate-btn py-2 px-3 rounded-lg border text-sm font-medium transition
                                        {{ $rate == 8 ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}"
                                        data-rate="{{ $rate }}">
                                        {{ $rate }}%
                                    </button>
                                @endforeach
                            </div>
                            <input type="number" id="custom-rate" value="8" step="0.1" min="1" max="20" 
                                class="w-full mt-3 rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="atau ketik suku bunga custom">
                        </div>

                        <button type="button" onclick="calculateKPR()" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            Hitung Cicilan
                        </button>
                    </form>
                </div>

                {{-- Results --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Hasil Perhitungan</h3>
                        
                        <div class="bg-blue-50 rounded-xl p-6 text-center mb-4">
                            <p class="text-sm text-gray-600 mb-2">Estimasi Cicilan per Bulan</p>
                            <p id="monthly-payment" class="text-4xl font-bold text-blue-600">Rp 3.200.000</p>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Harga Properti</span>
                                <span id="result-price" class="font-semibold">Rp 500.000.000</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Uang Muka</span>
                                <span id="result-down-payment" class="font-semibold">Rp 100.000.000</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Jumlah Pinjaman</span>
                                <span id="result-loan" class="font-semibold">Rp 400.000.000</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Tenor</span>
                                <span id="result-tenor" class="font-semibold">20 Tahun</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Suku Bunga</span>
                                <span id="result-rate" class="font-semibold">8% per tahun</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-600">Total Pembayaran</span>
                                <span id="result-total" class="font-semibold text-blue-600">Rp 768.000.000</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Rincian Cicilan</h3>
                        <div class="h-48 flex items-center justify-center bg-gray-50 rounded-lg">
                            <span class="text-gray-400">Grafik Angsuran</span>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-xl p-6 border border-green-100">
                        <div class="flex items-start gap-3">
                            <i class="fa fa-info-circle text-green-600 mt-1"></i>
                            <div class="text-sm text-green-800">
                                <p class="font-semibold mb-1">Catatan:</p>
                                <p>Perhitungan ini hanya merupakan simulasi. Suku bunga dan persyaratan KPR dapat berubah sewaktu-waktu. Silakan hubungi bank terkait untuk informasi lebih lanjut.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips KPR --}}
            <div class="mt-12">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Tips Mendapatkan KPR Terbaik</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mb-3">
                            <i class="fa fa-file-text text-blue-600"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Siapkan Dokumen</h4>
                        <p class="text-sm text-gray-600">Pastikan semua dokumen seperti slip gaji, laporan keuangan, dan KTP sudah lengkap.</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mb-3">
                            <i class="fa fa-money text-green-600"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Bandingkan Rate</h4>
                        <p class="text-sm text-gray-600">Bandingkan suku bunga dari beberapa bank untuk mendapatkan deal terbaik.</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mb-3">
                            <i class="fa fa-calculator text-purple-600"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Hitung Kemampuan</h4>
                        <p class="text-sm text-gray-600">Pastikan cicilan tidak melebihi 30% dari pendapatan bulanan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedTenor = 20;
        let selectedRate = 8;

        document.querySelectorAll('.tenor-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tenor-btn').forEach(b => {
                    b.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                    b.classList.add('border-gray-300', 'text-gray-700');
                });
                this.classList.remove('border-gray-300', 'text-gray-700');
                this.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                selectedTenor = parseInt(this.dataset.tenor);
            });
        });

        document.querySelectorAll('.rate-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.rate-btn').forEach(b => {
                    b.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                    b.classList.add('border-gray-300', 'text-gray-700');
                });
                this.classList.remove('border-gray-300', 'text-gray-700');
                this.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                selectedRate = parseFloat(this.dataset.rate);
                document.getElementById('custom-rate').value = selectedRate;
            });
        });

        document.getElementById('custom-rate').addEventListener('input', function() {
            selectedRate = parseFloat(this.value) || 8;
            document.querySelectorAll('.rate-btn').forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                b.classList.add('border-gray-300', 'text-gray-700');
            });
        });

        function formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        function calculateKPR() {
            const price = parseFloat(document.getElementById('property-price').value) || 500000000;
            const downPaymentPercent = parseFloat(document.getElementById('down-payment-percent').value) || 20;
            const downPayment = price * (downPaymentPercent / 100);
            const loanAmount = price - downPayment;
            
            document.getElementById('down-payment-amount').textContent = formatRupiah(downPayment);
            
            const monthlyRate = (selectedRate / 100) / 12;
            const totalMonths = selectedTenor * 12;
            
            const monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, totalMonths)) / (Math.pow(1 + monthlyRate, totalMonths) - 1);
            const totalPayment = monthlyPayment * totalMonths;
            const totalInterest = totalPayment - loanAmount;

            document.getElementById('monthly-payment').textContent = formatRupiah(Math.round(monthlyPayment));
            document.getElementById('result-price').textContent = formatRupiah(price);
            document.getElementById('result-down-payment').textContent = formatRupiah(downPayment);
            document.getElementById('result-loan').textContent = formatRupiah(loanAmount);
            document.getElementById('result-tenor').textContent = selectedTenor + ' Tahun';
            document.getElementById('result-rate').textContent = selectedRate + '% per tahun';
            document.getElementById('result-total').textContent = formatRupiah(Math.round(totalPayment));
        }

        document.getElementById('property-price').addEventListener('input', function() {
            document.getElementById('price-range').value = this.value;
            calculateKPR();
        });

        document.getElementById('price-range').addEventListener('input', function() {
            document.getElementById('property-price').value = this.value;
            calculateKPR();
        });

        document.getElementById('down-payment-percent').addEventListener('input', calculateKPR);

        // Initial calculation
        calculateKPR();
    </script>
@endsection
