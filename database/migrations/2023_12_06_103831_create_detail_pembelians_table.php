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
        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pembelian');
            $table->integer('id_barang');
            $table->integer('jumlah');
            $table->string('uom');
            $table->double('harga');
            $table->double('bruto');
            $table->double('diskon');
            $table->double('netto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelians');
    }
};
