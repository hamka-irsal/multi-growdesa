<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTidakMampu extends Model
{
    use HasFactory;

    protected $table = 'surat_tidak_mampu';

    protected $fillable = [
        'desa_id',
        'penduduk_id',
        'surat_id',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

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
