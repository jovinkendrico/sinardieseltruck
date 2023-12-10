<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengecekan extends Model
{
    use HasFactory;

    protected $fillable = ['id_pengecekan','id_perlengkapan','kondisi','deskripsi'];

    public function perlengkapan(){
        return $this->belongsTo(Perlengkapan::class,'id_perlengkapan','id');
    }
}
