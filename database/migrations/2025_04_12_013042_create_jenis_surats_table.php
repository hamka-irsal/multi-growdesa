<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis')->unique();
            $table->string('format_nomor');
            $table->string('nama_tabel');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};
