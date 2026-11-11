
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

            // Relasi ke desa pemilik jenis surat.
            // Nullable agar jenis surat umum/legacy tetap bisa ditangani.
            $table->foreignId('desa_id')
                ->nullable()
                ->constrained('desa')
                ->nullOnDelete();

            // Identitas jenis surat
            $table->string('kode', 50)->nullable();
            $table->string('nama_jenis', 150);
            $table->string('slug', 100)->nullable();
            $table->text('deskripsi')->nullable();

            // Pengaturan nomor surat
            $table->string('format_nomor', 100);

            // Pengaturan pengajuan: warga, admin, atau keduanya
            $table->string('sumber_pengajuan', 20)
                ->default('keduanya');

            // Status jenis surat
            $table->string('status', 20)
                ->default('aktif');

            // Dipertahankan untuk kompatibilitas kode lama.
            // Nantinya bisa dihapus setelah semua relasi lama
            // ke tabel khusus surat tidak lagi digunakan.
            $table->string('nama_tabel')->nullable();

            $table->timestamps();

            // Kode dan slug unik per desa.
            // Pada MySQL, nilai NULL pada unique index
            // dapat muncul lebih dari sekali.
            $table->unique(
                ['desa_id', 'kode'],
                'jenis_surat_desa_kode_unique'
            );

            $table->unique(
                ['desa_id', 'slug'],
                'jenis_surat_desa_slug_unique'
            );

            // Mempermudah filter jenis surat berdasarkan desa/status.
            $table->index(
                ['desa_id', 'status'],
                'jenis_surat_desa_status_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};
