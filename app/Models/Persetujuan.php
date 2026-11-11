<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    use HasFactory;

    protected $table = 'persetujuan';

    protected $fillable = [
        'desa_id',
        'jenis_surat_id',
        'aparat_id',
        'jabatan',
        'file_ttd',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function aparat()
    {
        return $this->belongsTo(Aparat::class);
    }
}
