<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashMasuk extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal','id_bukti','id_akunmasuk','total'];
    public function akunmasuk(){
        return $this->belongsTo(SubAkuns::class,'id_akunmasuk','id');
    }
}
