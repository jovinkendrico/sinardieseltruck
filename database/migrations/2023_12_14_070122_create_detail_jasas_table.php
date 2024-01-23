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
        Schema::create('detail_jasas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_penjualan');
            $table->integer('id_jasa');
            $table->integer('id_pihakjasa');
            $table->bigInteger('harga_modal');
            $table->bigInteger('harga');
            $table->string('deskripsi');
            $table->integer('id_akunmasuk')->nullable();
            $table->bigInteger('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_jasas');
    }
};
