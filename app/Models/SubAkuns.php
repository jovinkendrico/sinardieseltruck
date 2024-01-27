<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAkuns extends Model
{
    use HasFactory;

    protected $fillable = ['nama','id_akun', 'nomor_akun', 'debit', 'kredit','saldo','saldo_awal'];

}
