<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratUsaha extends Model
{
    use HasFactory;

    protected $table = 'surat_usaha';

    protected $fillable = [
        'desa_id',
        'penduduk_id',
        'surat_id',
        'nama_usaha',
        'jenis_usaha',
        'alamat_usaha',
        'tahun_berdiri',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}
