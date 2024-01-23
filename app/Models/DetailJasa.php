<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJasa extends Model
{
    use HasFactory;

    protected $fillable = ['id_penjualan','id_jasa','id_pihakjasa','harga_modal','harga','deskripsi','id_akunmasuk','paid'];

    public function jasa(){
        return $this->belongsTo(Jasa::class,'id_jasa','id');
    }
    public function pihakjasa(){
        return $this->belongsTo(Pihakjasa::class,'id_pihakjasa','id');
    }
    public function penjualan(){
        return $this->belongsTo(Penjualan::class,'id_penjualan','id');
    }
}
