<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkeIndikatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lke_indikators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('urutan', false, false);
            $table->boolean('urutan_tampilkan')->default(0);
            $table->char('kode', 50);
            $table->string('alias', 255);
            $table->text('indikator');
            $table->text('penjelasan')->nullable();
            $table->boolean('aktif')->default(0);
            $table->integer('nilai', false, false)->nullable();
            $table->uuid('parent')->nullable();
            $table->char('tipe_jawaban', 30)->nullable();
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
        Schema::dropIfExists('lke_indikators');
    }
}
