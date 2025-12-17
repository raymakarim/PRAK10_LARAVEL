<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['keterangan', 'nominal', 'jenis', 'tanggal'];

}
