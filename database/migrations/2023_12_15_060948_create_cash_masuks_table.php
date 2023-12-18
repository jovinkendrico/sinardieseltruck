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
        Schema::create('cash_masuks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('id_bukti');
            $table->integer('id_akunmasuk');
            $table->bigInteger('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_masuks');
    }
};
