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
        Schema::create('detail_cash_masuks', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cashmasuk');
            $table->integer('id_akunkeluar');
            $table->string('id_bukti');
            $table->string('deskripsi');
            $table->bigInteger('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_cash_masuks');
    }
};
