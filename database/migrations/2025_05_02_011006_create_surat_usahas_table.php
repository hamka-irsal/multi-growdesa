<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surat_usaha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->nullable()->constrained('desa')->nullOnDelete();
            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            $table->foreignId('surat_id')->nullable()->constrained('surat')->onDelete('cascade');
            $table->string('nama_usaha');
            $table->string('jenis_usaha');
            $table->string('alamat_usaha');
            $table->year('tahun_berdiri');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat_usaha');
    }
};
