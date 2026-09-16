<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    use HasFactory;

    protected $table = 'surat_pengantar';

    protected $fillable = [
        'penduduk_id',
        'surat_id',
        'keperluan_antar',
        'keterangan_antar',
    ];

    // Relasi ke model Penduduk
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    // Relasi ke model Surat
    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}
