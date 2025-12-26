@extends('layout.master')
@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-6">Edit Transaksi</h2>
    
    <form action="{{ url('/transaksi/'.$transaksi->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Clue Soal 1: Wajib ada @method('PUT') --}}
        
        <div class="mb-4">
            <label>Keterangan</label>
            <input type="text" name="keterangan" value="{{ $transaksi->keterangan }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label>Nominal</label>
            <input type="number" name="nominal" value="{{ $transaksi->nominal }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label>Jenis</label>
            <select name="jenis" class="w-full border rounded p-2">
                <option value="pemasukan" {{ $transaksi->jenis == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ $transaksi->jenis == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>
        <div class="mb-4">
            <label>Tanggal</label>
            <input type="date" name="tanggal" value="{{ $transaksi->tanggal }}" class="w-full border rounded p-2">
        </div>
        
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Update Transaksi</button>
    </form>
</div>
@endsection