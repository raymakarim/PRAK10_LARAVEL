@extends('layout.master')
@section('title', 'Dashboard')
@section('content')

{{-- Bagian Atas: Card Saldo --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Saldo</h3>
        <p class="mt-2 text-3xl font-bold text-gray-900">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-medium text-emerald-500 uppercase tracking-wider">Pemasukan</h3>
        <p class="mt-2 text-3xl font-bold text-emerald-600">+ Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-sm font-medium text-rose-500 uppercase tracking-wider">Pengeluaran</h3>
        <p class="mt-2 text-3xl font-bold text-rose-600">- Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Tabel Riwayat --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-800">Riwayat Transaksi Terakhir</h2>
        <a href="{{ url('/transaksi/create') }}" class="text-sm text-indigo-600 font-medium hover:underline">Tambah Baru</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm">
                    <th class="px-6 py-3 font-medium">Tanggal</th>
                    <th class="px-6 py-3 font-medium">Keterangan</th>
                    <th class="px-6 py-3 font-medium">Jenis</th>
                    <th class="px-6 py-3 font-medium text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($dataTransaksi as $item)
                <tr class="hover:bg-gray-50 transition">
                    {{-- JAWABAN SOAL 2: Carbon Format --}}
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item['keterangan'] }}</td>
                    <td class="px-6 py-4 text-sm">
                        @if($item['jenis'] == 'pemasukan')
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Pemasukan</span>
                        @else
                            <span class="px-2 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold">Pengeluaran</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-right {{ $item['jenis'] == 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                        Rp {{ number_format($item['nominal'], 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection