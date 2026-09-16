<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'pendidikan',
        'tempat_lahir',
        'jenis_pekerjaan',
        'tanggal_lahir',
        'golongan_darah',
        'agama',
        'status_perkawinan',
        'status_hubungan_dalam_keluarga',
        'tanggal_perkawinan',
        'foto',
        'alamat',
        'desa_kelurahan',
        'kecamatan',
        'dusun',
        'kabupaten_kota',
        'provinsi',
        'kewarganegaraan',
        'ayah',
        'ibu',
        'no_hp',
        'foto_selfie',
        'foto_ktp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function surat()
    {
        return $this->hasMany(Surat::class, 'penduduk_id');
    }

    public function suratKehilangan()
    {
        return $this->hasMany(
            SuratKehilangan::class,
            'penduduk_id'
        );
    }

    public function suratKematian()
    {
        return $this->hasMany(
            SuratKematian::class,
            'penduduk_id'
        );
    }

    public function suratUsaha()
    {
        return $this->hasMany(
            SuratUsaha::class,
            'penduduk_id'
        );
    }

    public function suratTidakMampu()
    {
        return $this->hasMany(
            SuratTidakMampu::class,
            'penduduk_id'
        );
    }

    public function suratPengantar()
    {
        return $this->hasMany(
            SuratPengantar::class,
            'penduduk_id'
        );
    }
}
