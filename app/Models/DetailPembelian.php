<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{


    use HasFactory;

    protected $fillable = ['id_pembelian','id_barang','jumlah','harga','uom','bruto','diskon','netto'];
    public function barang(){
        return $this->belongsTo(Barang::class,'id_barang','id');
    }
}
