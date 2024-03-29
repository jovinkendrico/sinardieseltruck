<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('id_invoice');
            $table->date('tanggal');
            $table->integer('id_customer');
            $table->integer('id_truk');
            $table->bigInteger('pendapatanbarang')->nullable();
            $table->bigInteger('pendapatanjasa')->nullable();
            $table->bigInteger('netto');
            $table->date('jatuh_tempo');
            $table->integer('id_akunkeluarbarang');
            $table->integer('id_akunkeluarjasa');
            $table->bigInteger('total_jasa')->nullable();
            $table->string('status');
            $table->string('metode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
