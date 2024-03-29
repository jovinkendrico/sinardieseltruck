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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('id_invoice');
            $table->date('tanggal');
            $table->integer('id_supplier');
            $table->bigInteger('netto');
            $table->date('jatuh_tempo');
            $table->string('status');
            $table->string('metode')->nullable();
            $table->integer('id_akunmasuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
