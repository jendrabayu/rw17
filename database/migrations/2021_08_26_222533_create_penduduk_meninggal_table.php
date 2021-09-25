<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendudukMeninggalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penduduk_meninggal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rt_id')->constrained('rt')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agama_id')->constrained('agama')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('darah_id')->nullable()->constrained('darah')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pekerjaan_id')->nullable()->constrained('pekerjaan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('status_perkawinan_id')->nullable()->constrained('status_perkawinan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('pendidikan_id')->nullable()->constrained('pendidikan')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('kewarganegaraan', [1, 2, 3])->default(1)->comment('1 => WNI, 2 => WNA, 3 => Dua Kewarganegaraan');
            $table->string('nik', 16);
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['l', 'p'])->comment('l => laki-laki, p => perempuan');
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('alamat');
            $table->date('tanggal_kematian');
            $table->time('jam_kematian')->nullable();
            $table->string('tempat_kematian')->nullable();
            $table->string('sebab_kematian')->nullable();
            $table->string('tempat_pemakaman')->nullable();
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
        Schema::dropIfExists('penduduk_meninggal');
    }
}
