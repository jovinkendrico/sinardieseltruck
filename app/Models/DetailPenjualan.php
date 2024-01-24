<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $fillable = ['id_penjualan','id_barang','jumlah','harga','uom','bruto','diskon','netto','id_detailbarang'];
    public function barang(){
        return $this->belongsTo(Barang::class,'id_barang','id');
    }

    public function penjualan(){
        return $this->belongsTo(Penjualan::class,'id_penjualan','id');
    }
}
