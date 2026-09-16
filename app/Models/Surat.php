<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'kode_unik',
        'no_surat',
        'nama_lengkap',
        'jenis_surat_id',
        'tanggal_pengajuan',
        'tanggal_dibuat',
        'status_surat',
        'persetujuan',
        'dibuat_oleh',
        'keterangan',
        'file_surat',
        'penduduk_id'
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate kode_unik saat membuat surat
        static::creating(function ($surat) {
            $tanggalSekarang = now();
            $datePrefix = $tanggalSekarang->format('Ymd');

            $lastKodeUnik = self::whereDate('created_at', $tanggalSekarang->toDateString())
                ->orderByDesc('id')
                ->first();

            $lastNumberUnik = $lastKodeUnik ? (int)substr($lastKodeUnik->kode_unik, -4) : 0;
            $newNumberUnik = str_pad($lastNumberUnik + 1, 4, '0', STR_PAD_LEFT);

            $surat->kode_unik = $datePrefix . $newNumberUnik;
        });

        // Generate no_surat saat status menjadi 'selesai'
        // static::updating(function ($surat) {
        //     if ($surat->status_surat === 'selesai' && empty($surat->no_surat)) {
        //         $tanggalSekarang = now();
        //         $tahun = $tanggalSekarang->format('Y');
        //         $bulan = (int)$tanggalSekarang->format('m');
        //         $bulanRomawi = self::convertToRoman($bulan);
        //         $kodeTempat = 'BRN';

        //         $lastSurat = self::whereYear('tanggal_pengajuan', $tahun)
        //             ->whereMonth('tanggal_pengajuan', $bulan)
        //             ->whereNotNull('no_surat')
        //             ->orderByDesc('id')
        //             ->first();

        //         $lastNumber = $lastSurat ? (int)explode('/', $lastSurat->no_surat)[0] + 1 : 1;
        //         $nomorUrut = str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

        //         $surat->no_surat = "$nomorUrut/$kodeTempat/$bulanRomawi/$tahun";
        //     }
        // });
    }

    // protected static function convertToRoman($month)
    // {
    //     $romawi = [
    //         1 => 'I',
    //         2 => 'II',
    //         3 => 'III',
    //         4 => 'IV',
    //         5 => 'V',
    //         6 => 'VI',
    //         7 => 'VII',
    //         8 => 'VIII',
    //         9 => 'IX',
    //         10 => 'X',
    //         11 => 'XI',
    //         12 => 'XII',
    //     ];

    //     return $romawi[$month] ?? $month;
    // }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function suratKehilangan()
    {
        return $this->hasOne(SuratKehilangan::class, 'surat_id');
    }

    public function suratKematian()
    {
        return $this->hasOne(SuratKematian::class, 'surat_id');
    }

    public function suratUsaha()
    {
        return $this->hasOne(SuratUsaha::class, 'surat_id');
    }

    public function suratTidakMampu()
    {
        return $this->hasOne(SuratTidakMampu::class, 'surat_id');
    }

}
