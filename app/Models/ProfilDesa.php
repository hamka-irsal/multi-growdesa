<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    protected $table = 'profil_desa';

    protected $fillable = [
        'selamat_datang',
        'nama_kepdes',
        'foto_kepdes',
        'logo_desa',
        'tentang_desa',
        'nama_desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'tlp_desa',
        'email_desa',
        'kontak_sekdes',
        'kontak_babinsa',
        'kontak_bhabinkamtibmas',
        'sejarah_desa',
        'visi',
        'misi',
        'alamat_peta',
        'alamat_kantor',
        'sosmed_ig',
        'sosmed_fb',
        'sosmed_yt',
        'sosmed_tiktok',
    ];
}
