<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSubAkuns extends Model
{
    use HasFactory;

    public function subakun(){
        return $this->belongsTo(SubAkuns::class,'id_subakun','id');
    }
}
