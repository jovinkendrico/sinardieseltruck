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
        Schema::create('detail_barangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('id_barang');
            $table->string('id_invoice');
            $table->integer('masuk');
            $table->bigInteger('harga_masuk')->nullable();
            $table->integer('keluar');
            $table->bigInteger('harga_keluar')->nullable();
            $table->integer('stokdetail');
            $table->integer('stokakhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_barangs');
    }
};
