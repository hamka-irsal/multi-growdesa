<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('apbdes', function (Blueprint $table) {
            $table->id();

            $table->year('tahun')->unique();

            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->decimal('realisasi_pendapatan', 15, 2)->default(0);

            $table->decimal('total_belanja', 15, 2)->default(0);
            $table->decimal('realisasi_belanja', 15, 2)->default(0);

            $table->decimal('total_pembiayaan', 15, 2)->default(0);
            $table->decimal('realisasi_pembiayaan', 15, 2)->default(0);

            $table->decimal('silpa_tahun_lalu', 15, 2)->default(0);

            $table->decimal('pemerintahan', 15, 2)->default(0);
            $table->decimal('pembangunan', 15, 2)->default(0);
            $table->decimal('pemberdayaan', 15, 2)->default(0);
            $table->decimal('lainnya', 15, 2)->default(0);

            $table->enum('status', [
                'draft',
                'published',
                'archived'
            ])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apbdes');
    }
};
