<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profil_desa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->nullable()->constrained('desa')->nullOnDelete();
            // Profil utama
            $table->text('selamat_datang')->nullable();
            $table->string('nama_kepdes');
            $table->string('foto_kepdes')->nullable();
            $table->string('logo_desa')->nullable();
            $table->text('tentang_desa')->nullable();

            // Identitas desa
            $table->string('nama_desa');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->string('kode_pos');

            // Kontak desa
            $table->string('tlp_desa')->nullable();
            $table->string('email_desa')->nullable();
            $table->string('kontak_sekdes');
            $table->string('kontak_babinsa');
            $table->string('kontak_bhabinkamtibmas');

            // Informasi desa
            $table->text('sejarah_desa')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->text('alamat_peta')->nullable();

            // Sosial media
            $table->string('sosmed_ig')->nullable();
            $table->string('sosmed_fb')->nullable();
            $table->string('sosmed_yt')->nullable();
            $table->string('sosmed_tiktok')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profil_desa');
    }
};
