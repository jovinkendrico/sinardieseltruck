<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal','id_barang','id_invoice','masuk','harga_masuk','keluar','stokakhir','stokdetail'];
}
