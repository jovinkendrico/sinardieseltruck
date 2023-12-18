<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCashMasuk extends Model
{
    use HasFactory;

    public function akunkeluar(){
        return $this->belongsTo(SubAkuns::class,'id_akunkeluar','id');
    }
}
