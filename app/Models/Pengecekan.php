<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengecekan extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal','id_truk','pemeriksa','service'];
    public function truk(){
        return $this->belongsTo(Truk::class,'id_truk','id');
    }
}
