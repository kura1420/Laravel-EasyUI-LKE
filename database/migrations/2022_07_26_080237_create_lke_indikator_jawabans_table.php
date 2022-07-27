<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkeIndikatorJawabansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lke_indikator_jawabans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('urutan', false, false);
            $table->string('jawaban', 255);
            $table->integer('nilai', false, false)->default(0);
            $table->text('penjelasan')->nullable();
            $table->boolean('aktif')->default(0);

            $table->foreignUuid('lke_id');
            $table->foreignUuid('lke_indikator_id');
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
        Schema::dropIfExists('lke_indikator_jawabans');
    }
}
