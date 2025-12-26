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

{{-- JAWABAN SOAL 2: Search Bar --}}
<div class="mb-6">
    <form action="{{ url('/') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Cari berdasarkan keterangan..." 
               class="w-full md:w-1/3 px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ url('/') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-200 transition"> Reset </a>
        @endif
    </form>
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
                    {{-- JAWABAN SOAL 3: Header Kolom Kategori --}}
                    <th class="px-6 py-3 font-medium">Kategori</th>
                    <th class="px-6 py-3 font-medium">Jenis</th>
                    <th class="px-6 py-3 font-medium text-right">Nominal</th>
                    {{-- JAWABAN SOAL 1: Kolom Aksi --}}
                    <th class="px-6 py-3 font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($dataTransaksi as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->keterangan }}</td>
                    
                    {{-- JAWABAN SOAL 3: Menampilkan Nama Kategori melalui Relasi --}}
                    <td class="px-6 py-4 text-sm text-gray-600 italic">
                        {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                    </td>

                    <td class="px-6 py-4 text-sm">
                        @if($item->jenis == 'pemasukan')
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Pemasukan</span>
                        @else
                            <span class="px-2 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold">Pengeluaran</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-right {{ $item->jenis == 'pemasukan' ? 'text-emerald-600' : 'text-rose-600' }}">
                        Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </td>
                    {{-- JAWABAN SOAL 1: Tombol Edit & Delete --}}
                    <td class="px-6 py-4 text-sm text-center">
                        <div class="flex justify-center items-center space-x-3">
                            {{-- Edit --}}
                            <a href="{{ url('/transaksi/'.$item->id.'/edit') }}" class="text-amber-500 hover:text-amber-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            {{-- Delete dengan Konfirmasi JS --}}
                            <form action="{{ url('/transaksi/'.$item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- JAWABAN SOAL 2: Pagination Links --}}
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $dataTransaksi->appends(request()->query())->links() }}
    </div>
</div>
@endsection