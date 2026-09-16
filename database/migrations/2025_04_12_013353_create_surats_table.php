<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->nullable()->constrained('penduduk')->cascadeOnDelete();
            $table->foreignId('jenis_surat_id')->nullable()->constrained('jenis_surat')->nullOnDelete();
            $table->string('kode_unik', 20)->unique();
            $table->string('no_surat', 50)->unique()->nullable();
            $table->string('nama_lengkap', 100)->nullable();
            $table->dateTime('tanggal_pengajuan')->nullable();
            $table->dateTime('tanggal_dibuat')->nullable();
            $table->enum('status_surat', ['proses', 'selesai', 'tolak'])->default('proses');
            $table->string('persetujuan', 100)->nullable();
            $table->string('dibuat_oleh', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->text('file_surat')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
