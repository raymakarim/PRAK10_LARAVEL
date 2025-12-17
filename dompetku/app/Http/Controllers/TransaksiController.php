<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi; // Tambahkan ini

class TransaksiController extends Controller
{
    public function index()
    {
        // Ambil data asli dari Database (Bukan array statis lagi)
        $transaksi = Transaksi::all();
        
        $totalPemasukan = Transaksi::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('transaksi.index', [
            'dataTransaksi' => $transaksi,
            'saldo' => $saldo,
            'pemasukan' => $totalPemasukan,
            'pengeluaran' => $totalPengeluaran
        ]);
    }

    public function create()
    {
        return view('transaksi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keterangan' => 'required|min:5|max:100',
            'nominal' => 'required|numeric|min:1000',
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'tanggal' => 'required|date'
        ]);

        // Simpan data asli ke Database
        Transaksi::create($validated);

        return redirect('/')->with('success', 'Data transaksi berhasil disimpan ke database!');
    }

// Menampilkan halaman login
public function loginView() 
{
    return view('login');
}

// Proses pengecekan login (Hardcode)
public function loginProcess(Request $request) 
{
    // Cek sesuai permintaan soal: admin@dompetku.com & admin
    if ($request->email == 'admin@dompetku.com' && $request->password == 'admin') {
        session(['is_logged_in' => true]); // Simpan session
        return redirect('/'); // Alihkan ke Dashboard
    }

    // Jika salah, balik ke login dengan pesan error
    return back()->with('error', 'Email atau Password salah!');
}


    public function logout(Request $request) 
    {
        // Menghapus session login sesuai instruksi Soal 1
        $request->session()->forget('is_logged_in');
        
        // Opsional: Menghapus semua session agar benar-benar bersih
        $request->session()->flush(); 

        // Alihkan kembali ke halaman login
        return redirect('/login')->with('success', 'Berhasil keluar!');
    }

    // Fungsi untuk Soal 3: Laporan VIP
    public function laporan()
    {
        // Ambil total pemasukan & pengeluaran asli dari DB
        $pemasukan = Transaksi::where('jenis', 'pemasukan')->sum('nominal');
        $pengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('nominal');
        $tabungan = $pemasukan - $pengeluaran;

        // Kirim ke view
        return view('transaksi.laporan', compact('pemasukan', 'pengeluaran', 'tabungan'));
    }
} // Ini kurung kurawal penutup class
