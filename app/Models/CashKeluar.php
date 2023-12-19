<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashKeluar extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal','id_bukti','id_akunkeluar','deskripsi','total'];

    public function akunkeluar(){
        return $this->belongsTo(SubAkuns::class,'id_akunkeluar','id');
    }
}
