<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkeIndikatorNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lke_indikator_nilais', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('nilai', false, false)->default(0);
            $table->foreignUuid('lke_id');
            $table->foreignId('lke_predikat_id')->comment('lke predikat nilai minimal');
            $table->foreignUuid('lke_indikator_id');
            $table->foreignId('predikat_id');
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
        Schema::dropIfExists('lke_indikator_nilais');
    }
}
