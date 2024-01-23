<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal','id_supplier','id_truk','pendapatanbarang','pendapatanjasa','id_invoice','jatuh_tempo','netto','status','id_akunkeluarbarang','id_akunkeluarjasa','total_jasa'];

    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer','id');
    }
    public function truk(){
        return $this->belongsTo(Truk::class,'id_truk','id');
    }
}
