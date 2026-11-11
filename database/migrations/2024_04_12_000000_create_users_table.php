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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->nullable()->constrained('desa')->nullOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nik', 16)->unique()->nullable(); // Tambahan field NIK
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status_verifikasi', [
                'pending',
                'disetujui',
                'ditolak'
            ])->default('pending');

            // 🔽 Tambahan field role
            $table->enum('role', ['superadmin', 'admindesa', 'aparat', 'penduduk'])->default('penduduk');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
