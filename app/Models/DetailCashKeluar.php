<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCashKeluar extends Model
{
    use HasFactory;
    protected $fillable = ['id_cashkeluar','id_bukti','id_akunmasuk','deskripsi','jumlah'];

    public function akunmasuk(){
        return $this->belongsTo(SubAkuns::class,'id_akunmasuk','id');
    }
}
