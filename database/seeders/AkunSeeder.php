<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('akuns')->insert([
            'nama' => 'Bank',
            'nomor_akun' => '111',
            'debit' => 0,
            'kredit' => 0,
            'saldo' =>0
        ]);
        DB::table('akuns')->insert([
            'nama' => 'Kas',
            'nomor_akun' => '112',
            'debit' => 0,
            'kredit' => 0,
            'saldo' =>0
        ]);
        DB::table('akuns')->insert([
            'nama' => 'Piutang',
            'nomor_akun' => '120',
            'debit' => 0,
            'kredit' => 0,
            'saldo' =>0
        ]);
        DB::table('akuns')->insert([
            'nama' => 'Hutang',
            'nomor_akun' => '210',
            'debit' => 0,
            'kredit' => 0,
            'saldo' =>0
        ]);
        DB::table('akuns')->insert([
            'nama' => 'Aset',
            'nomor_akun' => '310',
            'debit' => 0,
            'kredit' => 0,
            'saldo' =>0
        ]);
        DB::table('akuns')->insert([
            'nama' => 'Penjualan',
            'nomor_akun' => '410',
            'debit' => 0,
            'kredit' => 0,
            'saldo' =>0
        ]);
        DB::table('akuns')->insert([
            'nama' => 'Biaya',
            'nomor_akun' => '510',
            'debit' => 0,
            'kredit' => 0,
            'saldo' =>0
        ]);
    }
}
