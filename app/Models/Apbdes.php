<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    use HasFactory;

    protected $table = 'apbdes';

    protected $fillable = [
        'desa_id',
        'tahun',
        'total_pendapatan',
        'realisasi_pendapatan',
        'total_belanja',
        'realisasi_belanja',
        'total_pembiayaan',
        'realisasi_pembiayaan',
        'silpa_tahun_lalu',
        'pemerintahan',
        'pembangunan',
        'pemberdayaan',
        'lainnya',
        'status',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'total_pendapatan' => 'decimal:2',
        'realisasi_pendapatan' => 'decimal:2',
        'total_belanja' => 'decimal:2',
        'realisasi_belanja' => 'decimal:2',
        'total_pembiayaan' => 'decimal:2',
        'realisasi_pembiayaan' => 'decimal:2',
        'silpa_tahun_lalu' => 'decimal:2',
        'pemerintahan' => 'decimal:2',
        'pembangunan' => 'decimal:2',
        'pemberdayaan' => 'decimal:2',
        'lainnya' => 'decimal:2',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
