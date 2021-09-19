<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendudukDomisiliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penduduk_domisili', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rt_id')->constrained('rt')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agama_id')->constrained('agama')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('darah_id')->nullable()->constrained('darah')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pekerjaan_id')->nullable()->constrained('pekerjaan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('status_perkawinan_id')->nullable()->constrained('status_perkawinan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pendidikan_id')->nullable()->constrained('pendidikan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('rumah_id')->nullable()->constrained('rumah')->onUpdate('cascade');
            $table->enum('kewarganegaraan', [1, 2, 3])->comment('1 => WNI, 2 => WNA, 3 => Dua Kewarganegaraan');
            $table->string('nik', 16);
            $table->string('nama', 100);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['l', 'p'])->comment('l => laki-laki, p => perempuan');
            $table->string('alamat');
            $table->string('alamat_asal')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('penduduk_domisili');
    }
}
