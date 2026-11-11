
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_surat_fields', function (Blueprint $table) {
            $table->id();

            $table->foreignId('desa_id')
                ->constrained('desa')
                ->cascadeOnDelete();

            $table->foreignId('template_surat_id')
                ->constrained('template_surat')
                ->cascadeOnDelete();

            // Identitas field, misalnya tgl_kematian
            $table->string('field_key', 100);

            // Label pada formulir, misalnya Tanggal Kematian
            $table->string('label', 150);

            // text, textarea, date, number, select, checkbox
            $table->string('tipe_input', 30)->default('text');

            // manual, penduduk, atau sistem
            $table->string('sumber_data', 30)->default('manual');

            // Contoh: penduduk.nama_lengkap
            // Hanya boleh memakai sumber field yang diizinkan backend.
            $table->string('sumber_field', 150)->nullable();

            $table->boolean('required')->default(false);

            // Pilihan untuk select/radio, jika diperlukan
            $table->json('options')->nullable();

            // Aturan validasi tambahan
            $table->json('validasi')->nullable();

            $table->string('placeholder')->nullable();
            $table->text('petunjuk')->nullable();

            $table->unsignedInteger('urutan')->default(0);

            $table->boolean('aktif')->default(true);

            $table->timestamps();

            // Satu key hanya boleh muncul sekali per template
            $table->unique(
                ['template_surat_id', 'field_key'],
                'template_surat_fields_template_key_unique'
            );

            $table->index(
                ['desa_id', 'template_surat_id', 'aktif'],
                'template_surat_fields_desa_template_aktif_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_surat_fields');
    }
};
