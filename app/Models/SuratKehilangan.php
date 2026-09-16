<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SuratKehilangan extends Model
{
    use HasFactory;

    protected $table = 'surat_kehilangan';

    protected $fillable = [
        'penduduk_id',
        'surat_id',
        'barang_hilang',
        'keperluan_kepengurusan',
    ];

    // Relasi ke penduduk
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    // Relasi ke surat utama (jika tetap digunakan)
    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }
}
