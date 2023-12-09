<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nama')->nullable();
            $table->integer('harga')->nullable();
            $table->integer('satuanbesar')->nullable();
            $table->integer('satuankecil')->nullable();
            $table->string('uombesar')->nullable();
            $table->string('uomkecil')->nullable();
            $table->integer('stok')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('barangs');
    }
}
