<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkeJawabanSatkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lke_jawaban_satkers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('jawaban', 255)->nullable();
            $table->text('catatan')->nullable();
            $table->text('bukti')->nullable();
            $table->foreignId('satker_id');
            $table->foreignUuid('lke_id');
            $table->foreignId('predikat_id');
            $table->foreignUuid('lke_pengusulan_satker_id');
            $table->foreignUuid('lke_indikator_id');
            $table->foreignUuid('lke_indikator_jawaban_id');
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
        Schema::dropIfExists('lke_jawaban_satkers');
    }
}
