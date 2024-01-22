<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $casts = [
        'tanggal' => 'datetime',
        'jatuh_tempo' =>'datetime'
    ];
    protected $fillable = ['tanggal','id_supplier','id_invoice','jatuh_tempo','netto','status','id_akunmasuk'];

    public function supplier(){
        return $this->belongsTo(Supplier::class,'id_supplier','id');
    }

}
