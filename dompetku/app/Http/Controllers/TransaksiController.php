<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi; // Tambahkan ini

class TransaksiController extends Controller
{
public function index(Request $request) // Tambahkan parameter Request
{
    // Logika Pencarian (Soal 2: Search Bar)
    $query = Transaksi::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('keterangan', 'like', '%' . $request->search . '%');
    }

    // Logika Pagination (Soal 2: Pagination)
    // Ganti Transaksi::all() menjadi paginate(10)
   $transaksi = $query->with('kategori')->paginate(10); 
    
    // Perhitungan saldo tetap menggunakan semua data di DB agar akurat
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


    public function edit($id)
{
    // Mengambil data lama berdasarkan ID
    $transaksi = Transaksi::findOrFail($id);
    return view('transaksi.edit', compact('transaksi'));
}

public function update(Request $request, $id)
{
    // Validasi data (opsional tapi disarankan)
    $request->validate([
        'keterangan' => 'required',
        'nominal' => 'required|numeric',
    ]);

    $transaksi = Transaksi::findOrFail($id);
    $transaksi->update($request->all());

    return redirect('/')->with('success', 'Data berhasil diperbarui!');
}

public function destroy($id)
{
    $transaksi = Transaksi::findOrFail($id);
    $transaksi->delete();

    return redirect('/')->with('success', 'Data berhasil dihapus!');
}
} // Ini kurung kurawal penutup class
