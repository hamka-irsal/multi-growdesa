<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSurat extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat';

    protected $fillable = [
        'desa_id',
        'kode',
        'nama_jenis',
        'slug',
        'deskripsi',
        'format_nomor',
        'sumber_pengajuan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'desa_id' => 'integer',
        ];
    }

    /**
     * Desa pemilik jenis surat.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    /**
     * Konfigurasi persetujuan jenis surat.
     * Pertahankan relasi ini jika masih digunakan aplikasi lama.
     */
    public function persetujuan(): HasMany
    {
        return $this->hasMany(Persetujuan::class, 'jenis_surat_id');
    }

    /**
     * Versi-versi template untuk jenis surat ini.
     */
    public function templates(): HasMany
    {
        return $this->hasMany(
            TemplateSurat::class,
            'jenis_surat_id'
        );
    }

    /**
     * Template aktif yang sedang digunakan.
     */
    public function templateAktif()
    {
        return $this->hasOne(
            TemplateSurat::class,
            'jenis_surat_id'
        )
            ->where('status', 'aktif')
            ->where('is_current', true);
    }
}
