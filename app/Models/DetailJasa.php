<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJasa extends Model
{
    use HasFactory;

    protected $fillable = ['id_penjualan','id_jasa','harga','deskripsi'];

    public function jasa(){
        return $this->belongsTo(Jasa::class,'id_jasa','id');
    }
}
