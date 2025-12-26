<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    // Tambahkan 'kategori_id' ke dalam array fillable
    protected $fillable = ['keterangan', 'nominal', 'jenis', 'tanggal', 'kategori_id'];

    // Tambahkan fungsi relasi ini
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}