<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer','id');
    }
    public function truk(){
        return $this->belongsTo(Truk::class,'id_truk','id');
    }
}
