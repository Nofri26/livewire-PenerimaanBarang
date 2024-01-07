<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berat', function (Blueprint $table) {
            $table->id();
            $table->decimal('berat_real', 3, 2);
            $table->decimal('berat_kotor', 3, 2);
            $table->unsignedBigInteger('penerima_id');
            $table->unsignedBigInteger('karat_id');

            $table->foreign('penerima_id')->references('id')->on('penerima')->onDelete('cascade');
            $table->foreign('karat_id')->references('id')->on('karat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berat');
    }
}
