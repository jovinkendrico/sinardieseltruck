<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSubAkuns extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal','id_subakun','id_bukti','deskripsi','debit','kredit'];

    public function subakun(){
        return $this->belongsTo(SubAkuns::class,'id_subakun','id');
    }
}
