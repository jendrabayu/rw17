<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRumahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rumah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rt_id')->constrained('rt')->onDelete('cascade')->onUpdate('cascade');
            $table->string('alamat');
            $table->string('nomor');
            $table->foreignId('penggunaan_bangunan_id')
                ->constrained('penggunaan_bangunan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyText('keterangan')->nullable();
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
        Schema::dropIfExists('rumah');
    }
}
