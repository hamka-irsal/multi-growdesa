<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'desa_id',
        'kode_unik',
        'no_surat',
        'nama_lengkap',
        'jenis_surat_id',
        'template_surat_id',
        'tanggal_pengajuan',
        'tanggal_dibuat',
        'status_surat',
        'persetujuan',
        'dibuat_oleh',
        'keterangan',
        'file_surat',
        'penduduk_id',
        'data_snapshot',
    ];

    protected function casts(): array
    {
        return [
            'desa_id' => 'integer',
            'penduduk_id' => 'integer',
            'jenis_surat_id' => 'integer',
            'template_surat_id' => 'integer',
            'tanggal_pengajuan' => 'datetime',
            'tanggal_dibuat' => 'datetime',
            'data_snapshot' => 'array',
        ];
    }

    /**
     * Generate kode unik jika belum diberikan.
     *
     * Format: YYYYMMDD + 10 karakter acak.
     * Contoh: 20261023A7B8C9D2EF
     *
     * Indeks UNIQUE pada database tetap menjadi
     * perlindungan utama terhadap duplikasi.
     */
    protected static function booted(): void
    {
        static::creating(function (Surat $surat) {
            if (empty($surat->kode_unik)) {
                do {
                    $kode = now()->format('Ymd')
                        . Str::upper(Str::random(10));
                } while (
                    static::where('kode_unik', $kode)->exists()
                );

                $surat->kode_unik = $kode;
            }
        });
    }

    /**
     * Desa pemilik surat.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    /**
     * Penduduk yang mengajukan surat.
     */
    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    /**
     * Jenis surat, misalnya Surat Kematian atau Surat Usaha.
     */
    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    /**
     * Template yang digunakan untuk surat ini.
     * Model TemplateSurat dibuat pada tahap berikutnya.
     */
    public function templateSurat(): BelongsTo
    {
        return $this->belongsTo(
            TemplateSurat::class,
            'template_surat_id'
        );
    }

    /*
     * RELASI KOMPATIBILITAS SISTEM LAMA
     *
     * Pertahankan sementara selama controller, API,
     * atau proses PDF lama masih menggunakannya.
     * Hapus setelah migrasi sistem dinamis selesai.
     */

    public function suratKehilangan(): HasOne
    {
        return $this->hasOne(SuratKehilangan::class, 'surat_id');
    }

    public function suratKematian(): HasOne
    {
        return $this->hasOne(SuratKematian::class, 'surat_id');
    }

    public function suratUsaha(): HasOne
    {
        return $this->hasOne(SuratUsaha::class, 'surat_id');
    }

    public function suratTidakMampu(): HasOne
    {
        return $this->hasOne(SuratTidakMampu::class, 'surat_id');
    }
}
