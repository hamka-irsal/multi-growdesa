<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('surat_kehilangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->nullable()->constrained('desa')->nullOnDelete();
            $table->foreignId('penduduk_id')->constrained('penduduk')->onDelete('cascade');
            $table->foreignId('surat_id')->nullable()->constrained('surat')->onDelete('cascade');
            $table->string('barang_hilang')->nullable();
            $table->string('keperluan_kepengurusan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat_kehilangan');
    }
};
