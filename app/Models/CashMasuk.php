<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashMasuk extends Model
{
    use HasFactory;

    public function akunmasuk(){
        return $this->belongsTo(SubAkuns::class,'id_akunmasuk','id');
    }
}
