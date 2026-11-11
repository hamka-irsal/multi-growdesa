
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('desa_id')
                ->nullable()
                ->constrained('desa')
                ->nullOnDelete();

            $table->foreignId('penduduk_id')
                ->nullable()
                ->constrained('penduduk')
                ->nullOnDelete();

            $table->foreignId('jenis_surat_id')
                ->nullable()
                ->constrained('jenis_surat')
                ->nullOnDelete();

            // Template dinamis yang digunakan
            $table->foreignId('template_surat_id')
                ->nullable()
                ->constrained('template_surat')
                ->nullOnDelete();

            // Identitas surat
            $table->string('kode_unik', 30)->unique();
            $table->string('no_surat', 50)->nullable()->unique();
            $table->string('nama_lengkap', 100)->nullable();

            // Waktu pengajuan dan penerbitan
            $table->dateTime('tanggal_pengajuan')->nullable();
            $table->dateTime('tanggal_dibuat')->nullable();

            // Status dan informasi proses
            $table->enum('status_surat', [
                'proses',
                'selesai',
                'tolak',
            ])->default('proses');

            $table->string('persetujuan', 100)->nullable();
            $table->string('dibuat_oleh', 100)->nullable();
            $table->text('keterangan')->nullable();
            $table->text('file_surat')->nullable();

            // Snapshot data ketika surat diajukan atau diterbitkan
            $table->json('data_snapshot')->nullable();

            $table->timestamps();

            // Indeks untuk pencarian berdasarkan desa dan status
            $table->index(
                ['desa_id', 'status_surat'],
                'surat_desa_status_index'
            );

            $table->index(
                ['desa_id', 'jenis_surat_id'],
                'surat_desa_jenis_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
