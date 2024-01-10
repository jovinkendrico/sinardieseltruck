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
        Schema::create('detail_sub_akuns', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->integer('id_subakun');
            $table->string('deskripsi');
            $table->bigInteger('debit');
            $table->bigInteger('kredit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_sub_akuns');
    }
};
