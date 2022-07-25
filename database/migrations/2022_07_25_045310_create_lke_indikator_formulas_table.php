<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkeIndikatorFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lke_indikator_formulas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('urutan', false, false);
            $table->char('rumus', 20);
            $table->foreignUuid('lke_indikator_id_target');
            $table->boolean('nilai_maksimal')->default(0);
            $table->boolean('nilai_maksimal_mengurangi')->default(0);
            $table->char('tipe_penilaian', 20);
            $table->char('nilai_bilangan', 30)->nullable();
            $table->char('nilai_bawaaan', 30)->nullable();
            $table->text('keterangan')->nullable();

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
        Schema::dropIfExists('lke_indikator_formulas');
    }
}
