
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_surat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('desa_id')
                ->constrained('desa')
                ->cascadeOnDelete();

            $table->foreignId('jenis_surat_id')
                ->constrained('jenis_surat')
                ->cascadeOnDelete();

            // Nomor versi template untuk setiap jenis surat
            $table->unsignedInteger('versi')->default(1);

            $table->string('nama_template', 150);

            // Konten HTML dari editor visual
            $table->longText('konten_html');

            // Contoh: ukuran kertas, orientasi, margin
            $table->json('pengaturan_halaman')->nullable();

            // draft: sedang diedit
            // aktif: telah dipublikasikan
            // arsip: versi lama
            $table->enum('status', [
                'draft',
                'aktif',
                'arsip',
            ])->default('draft');

            // Menandai template yang saat ini digunakan
            $table->boolean('is_current')->default(false);

            $table->foreignId('dibuat_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            // Satu nomor versi hanya sekali untuk satu jenis surat
            $table->unique(
                ['jenis_surat_id', 'versi'],
                'template_surat_jenis_versi_unique'
            );

            $table->index(
                ['desa_id', 'status', 'is_current'],
                'template_surat_desa_status_current_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_surat');
    }
};
