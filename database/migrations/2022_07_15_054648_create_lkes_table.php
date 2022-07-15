<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lkes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 255);
            $table->boolean('aktif')->default(0);
            $table->text('keterangan')->nullable();
            $table->integer('tahun', false, false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lkes');
    }
}
