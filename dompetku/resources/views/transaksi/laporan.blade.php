@extends('layout.master')

@section('title', 'Laporan Eksklusif')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Keuangan <span class="text-amber-500">VIP</span></h1>
            <p class="text-gray-500 text-sm mt-1">Analisis mendalam kondisi finansial Anda bulan ini.</p>
        </div>
        <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-lg shadow-indigo-200">
            Status: Member Premium
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-16 h-16 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-6">Proporsi Arus Kas</h3>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="cashflowChart"></canvas>
            </div>
            <div class="mt-4 text-center text-sm text-gray-500">
                *Data berdasarkan transaksi bulan berjalan
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-700 mb-6">Tren Pengeluaran Mingguan</h3>
            <div class="relative h-64 w-full">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg p-8 text-white mb-8">
        <div class="flex items-start space-x-4">
            <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                <svg class="w-8 h-8 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-2">Insight Finansial AI</h3>
                <p class="text-indigo-100 leading-relaxed">
                    Pengeluaran Anda bulan ini terkendali. Porsi terbesar pengeluaran ada pada kategori <span class="font-bold text-white">Makanan & Minuman (45%)</span>. Disarankan untuk mengurangi frekuensi pembelian kopi untuk menghemat hingga Rp 500.000 bulan depan.
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Konfigurasi Chart 1: Doughnut Chart
        const ctx1 = document.getElementById('cashflowChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Pemasukan', 'Pengeluaran', 'Tabungan'],
                datasets: [{
                    data: [{{ $pemasukan }}, {{ $pengeluaran }}, {{ $tabungan }}], // Silakan ganti dengan data dinamis dari Controller nanti
                    backgroundColor: [
                        '#10b981', // Emerald 500 (Pemasukan)
                        '#f43f5e', // Rose 500 (Pengeluaran)
                        '#3b82f6'  // Blue 500 (Tabungan)
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });

        // Konfigurasi Chart 2: Bar Chart
        const ctx2 = document.getElementById('weeklyChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                    label: 'Pengeluaran (Rp)',
                    data: [1200000, 900000, 850000, 1500000],
                    backgroundColor: '#6366f1', // Indigo 500
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6' // Garis grid tipis
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection