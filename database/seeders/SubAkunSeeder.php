<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('sub_akuns')->insert([
            'id_akun' => 3,
            'nomor_akun' => 1201,
            'nama' => 'Piutang Dagang',
            'debit' => 0,
            'kredit' => 0,
            'saldo_awal' => 0,
            'saldo' => 0
        ]);
        DB::table('sub_akuns')->insert([
            'id_akun' => 4,
            'nomor_akun' => 2101,
            'nama' => 'Hutang Dagang',
            'debit' => 0,
            'kredit' => 0,
            'saldo_awal' => 0,
            'saldo' => 0
        ]);
        DB::table('sub_akuns')->insert([
            'id_akun' => 5,
            'nomor_akun' => 3101,
            'nama' => 'Aset Barang',
            'debit' => 0,
            'kredit' => 0,
            'saldo_awal' => 0,
            'saldo' => 0
        ]);
        DB::table('sub_akuns')->insert([
            'id_akun' => 6,
            'nomor_akun' => 4101,
            'nama' => 'Penjualan Barang',
            'debit' => 0,
            'kredit' => 0,
            'saldo_awal' => 0,
            'saldo' => 0
        ]);
        DB::table('sub_akuns')->insert([
            'id_akun' => 6,
            'nomor_akun' => 4102,
            'nama' => 'Penjualan Jasa',
            'debit' => 0,
            'kredit' => 0,
            'saldo_awal' => 0,
            'saldo' => 0
        ]);
    }
}
