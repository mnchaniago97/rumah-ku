@extends('frontend.layouts.app')

@section('content')
    <div class="bg-gray-50 py-8">
        <div class="max-w-[1200px] mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Cek Kelayakan Properti</h1>
                <p class="mt-2 text-gray-600">Periksa kelayakan properti sebelum Anda memutuskan untuk membeli</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                {{-- Eligibility Form --}}
                <div class="bg-white rounded-xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Formulir Cek Kelayakan</h2>
                    
                    <form id="eligibility-form">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="full-name" placeholder="Masukkan nama lengkap Anda" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" id="phone" placeholder="0812xxxxx" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" placeholder="email@anda.com" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                            <select id="occupation" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih pekerjaan</option>
                                <option value="employee">Karyawan</option>
                                <option value="self-employed">Wiraswasta</option>
                                <option value="professional">Profesional (Dokter, Advokat, dll)</option>
                                <option value="entrepreneur">Pengusaha</option>
                                <option value="retired">Pensiunan</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Penghasilan Bulanan (Rp)</label>
                            <input type="number" id="monthly-income" placeholder="10000000" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="range" id="income-range" min="3000000" max="100000000" value="10000000" step="1000000" 
                                class="w-full mt-2 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pengalaman KPR/Kredit</label>
                            <select id="kpr-experience" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih pengalaman</option>
                                <option value="first">Pertama Kali</option>
                                <option value="once">Pernah 1 kali</option>
                                <option value="multiple">Pernah lebih dari 1 kali</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Properti</label>
                            <select id="property-type" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih jenis properti</option>
                                <option value="house">Rumah Tinggal</option>
                                <option value="apartment">Apartemen</option>
                                <option value="villa">Villa</option>
                                <option value="townhouse">Townhouse</option>
                                <option value="land">Tanah</option>
                                <option value="ruko">Ruko</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target Harga Properti (Rp)</label>
                            <input type="number" id="target-price" placeholder="500000000" 
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                            <textarea id="notes" rows="3" placeholder="Informasi tambahan yang ingin disampaikan..." 
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <button type="button" onclick="checkEligibility()" class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                            Cek Kelayakan
                        </button>
                    </form>
                </div>

                {{-- Results & Info --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Hasil Analisis Kelayakan</h3>
                        
                        <div id="eligibility-result" class="hidden">
                            <div id="result-badge" class="hidden rounded-xl p-6 text-center mb-4">
                                <p id="result-text" class="text-2xl font-bold"></p>
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                    <span class="text-gray-600">Kemampuan Cicilan</span>
                                    <span id="result-payment" class="font-semibold">-</span>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                    <span class="text-gray-600">DP yang Diperlukan</span>
                                    <span id="result-downpayment" class="font-semibold">-</span>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                    <span class="text-gray-600">Tenor Maksimum</span>
                                    <span id="result-tenor" class="font-semibold">-</span>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                    <span class="text-gray-600">Keterangan</span>
                                    <span id="result-note" class="font-semibold">-</span>
                                </div>
                            </div>
                        </div>

                        <div id="no-result" class="text-center py-8 text-gray-500">
                            <i class="fa fa-search text-4xl text-gray-300 mb-3"></i>
                            <p>Isi formulir untuk melihat hasil analisis kelayakan</p>
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tips Meningkatkan Kelayakan</h3>
                        <div class="space-y-3 text-sm text-gray-700">
                            <div class="flex items-start gap-3">
                                <i class="fa fa-check-circle text-blue-600 mt-1"></i>
                                <p>Pertahankan rasio cicilan di bawah 30% dari penghasilan bulanan</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fa fa-check-circle text-blue-600 mt-1"></i>
                                <p>Siapkan DP minimal 20% dari harga properti</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fa fa-check-circle text-blue-600 mt-1"></i>
                                <p>Pastikan riwayat kredit bersih dari tunggakan</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="fa fa-check-circle text-blue-600 mt-1"></i>
                                <p>Stabilitas pendapatan meningkatkan peluang persetujuan</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 rounded-xl p-6 border border-green-100">
                        <div class="flex items-start gap-3">
                            <i class="fa fa-info-circle text-green-600 mt-1"></i>
                            <div class="text-sm text-green-800">
                                <p class="font-semibold mb-1">Catatan:</p>
                                <p>Hasil analisis ini hanya merupakan perkiraan. Untuk informasi lebih lanjut dan pengajuan KPR, silakan hubungi agent kami.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CTA Section --}}
            <div class="mt-12 bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-8 text-center text-white">
                <h3 class="text-2xl font-bold mb-3">Butuh Bantuan Lebih Lanjut?</h3>
                <p class="mb-6 text-blue-100">Konsultasikan dengan agent berpengalaman kami secara gratis</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('agents') }}" class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition">
                        Tanya Agent
                    </a>
                    <a href="{{ route('contact') }}" class="px-6 py-3 bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-600 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('monthly-income').addEventListener('input', function() {
            document.getElementById('income-range').value = this.value;
        });

        document.getElementById('income-range').addEventListener('input', function() {
            document.getElementById('monthly-income').value = this.value;
        });

        function formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        function checkEligibility() {
            const income = parseFloat(document.getElementById('monthly-income').value) || 0;
            const targetPrice = parseFloat(document.getElementById('target-price').value) || 0;
            const occupation = document.getElementById('occupation').value;
            const kprExperience = document.getElementById('kpr-experience').value;
            const propertyType = document.getElementById('property-type').value;

            // Validation
            if (!income || !targetPrice || !occupation || !kprExperience || !propertyType) {
                alert('Mohon lengkapi semua data terlebih dahulu!');
                return;
            }

            // Calculate max monthly payment (30% of income)
            const maxMonthlyPayment = income * 0.30;

            // Calculate required down payment (20% of target price)
            const requiredDownPayment = targetPrice * 0.20;

            // Calculate loan amount
            const loanAmount = targetPrice - requiredDownPayment;

            // Estimate max tenor based on income (assuming 8% interest rate)
            const monthlyRate = (8 / 100) / 12;
            let maxMonths = 240; // 20 years default max
            for (let months = 60; months <= 360; months += 12) {
                const payment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, months)) / (Math.pow(1 + monthlyRate, months) - 1);
                if (payment <= maxMonthlyPayment) {
                    maxMonths = months;
                } else {
                    break;
                }
            }

            // Determine eligibility status
            let status = '';
            let statusClass = '';
            let note = '';

            if (income >= 15000000 && requiredDownPayment <= income * 12) {
                status = 'SANGAT LAYAK';
                statusClass = 'bg-green-100 text-green-700';
                note = 'Penghasilan dan DP sangat memadai';
            } else if (income >= 8000000 && requiredDownPayment <= income * 18) {
                status = 'LAYAK';
                statusClass = 'bg-blue-100 text-blue-700';
                note = 'Penghasilan dan DP memadai';
            } else if (income >= 5000000 && requiredDownPayment <= income * 24) {
                status = 'CUKUP LAYAK';
                statusClass = 'bg-yellow-100 text-yellow-700';
                note = 'Perlu mempertimbangkan properti dengan harga lebih rendah';
            } else {
                status = 'PERLU EVALUASI';
                statusClass = 'bg-red-100 text-red-700';
                note = 'Disarankan menambah DP atau memilih properti dengan harga lebih terjangkau';
            }

            // Show results
            document.getElementById('no-result').classList.add('hidden');
            document.getElementById('eligibility-result').classList.remove('hidden');
            document.getElementById('result-badge').classList.remove('hidden');
            
            const badge = document.getElementById('result-badge');
            badge.className = 'rounded-xl p-6 text-center mb-4 ' + statusClass;
            document.getElementById('result-text').textContent = status;

            document.getElementById('result-payment').textContent = formatRupiah(Math.round(maxMonthlyPayment));
            document.getElementById('result-downpayment').textContent = formatRupiah(Math.round(requiredDownPayment));
            document.getElementById('result-tenor').textContent = Math.floor(maxMonths / 12) + ' Tahun';
            document.getElementById('result-note').textContent = note;
        }
    </script>
@endsection
