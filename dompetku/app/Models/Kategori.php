<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}