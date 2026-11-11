<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persetujuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->nullable()->constrained('desa')->nullOnDelete();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
            $table->foreignId('aparat_id')->constrained('aparat')->onDelete('cascade');
            $table->string('jabatan');
            $table->string('file_ttd');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persetujuan');
    }
};
