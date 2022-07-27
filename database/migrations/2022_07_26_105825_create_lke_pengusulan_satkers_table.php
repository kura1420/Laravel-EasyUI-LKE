<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLkePengusulanSatkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lke_pengusulan_satkers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('aktif')->default(0);
            $table->foreignId('satker_id');
            $table->foreignUuid('lke_id');
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
        Schema::dropIfExists('lke_pengusulan_satkers');
    }
}
