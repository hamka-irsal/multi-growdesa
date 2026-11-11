<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->nullable()->constrained('desa')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nik', 16)->unique()->nullable();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('pendidikan');
            $table->string('tempat_lahir');
            $table->string('jenis_pekerjaan');
            $table->date('tanggal_lahir')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('agama');
            $table->string('status_perkawinan');
            $table->string('status_hubungan_dalam_keluarga');
            $table->date('tanggal_perkawinan')->nullable();
            $table->string('foto')->nullable();
            $table->text('alamat');
            $table->string('kewarganegaraan');
            $table->string('ayah');
            $table->string('ibu');
            $table->string('no_hp')->nullable();
            $table->string('foto_selfie')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penduduk');
    }
};
