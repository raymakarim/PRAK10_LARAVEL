<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\CekTipeUser;
Route::get('/login', [TransaksiController::class, 'loginView']);
Route::post('/login', [TransaksiController::class, 'loginProcess']);
Route::get('/logout', [TransaksiController::class, 'logout']);

// --- RUTE TERPROTEKSI (Harus login dulu) ---
// Grup ini menggunakan middleware 'ceklogin' yang baru saja kamu daftarkan di app.php
Route::middleware(['ceklogin'])->group(function () {
    
    // 1. Dashboard
    Route::get('/', [TransaksiController::class, 'index']);
    
    // 2. Form Tambah Data
    Route::get('/transaksi/create', [TransaksiController::class, 'create']);
    
    // 3. Simpan Data
    Route::post('/transaksi', [TransaksiController::class, 'store']);
    
    // 4. Halaman Laporan VIP (Soal 3)
    Route::get('/laporan', [TransaksiController::class, 'laporan']);

    // 5. Form Edit Data
    Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit']);

    // 6. Simpan Perubahan (Update)
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update']);

    // 7. Hapus Data
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy']);
});