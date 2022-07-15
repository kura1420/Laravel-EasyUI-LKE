<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSatkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satkers', function (Blueprint $table) {
            $table->id();
            $table->char('kode', 50)->unique();
            $table->string('nama', 255);
            $table->string('provinsi', 255)->nullable();
            $table->string('kota', 255)->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->char('telp', 14)->nullable();
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
        Schema::dropIfExists('satkers');
    }
}
