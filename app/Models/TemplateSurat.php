<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $table = 'template_surat';

    protected $fillable = [
        'desa_id',
        'jenis_surat_id',
        'versi',
        'nama_template',
        'konten_html',
        'pengaturan_halaman',
        'status',
        'is_current',
        'dibuat_oleh',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'desa_id' => 'integer',
            'jenis_surat_id' => 'integer',
            'versi' => 'integer',
            'pengaturan_halaman' => 'array',
            'is_current' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Desa pemilik template.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    /**
     * Jenis surat yang menggunakan template ini.
     */
    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    /**
     * Field dinamis yang dikonfigurasi pada template.
     */
    public function fields(): HasMany
    {
        return $this->hasMany(
            TemplateSuratField::class,
            'template_surat_id'
        )->orderBy('urutan');
    }

    /**
     * Pengajuan surat yang merujuk template ini.
     */
    public function surat(): HasMany
    {
        return $this->hasMany(
            Surat::class,
            'template_surat_id'
        );
    }

    /**
     * Scope untuk template aktif yang dipublikasikan.
     */
    public function scopeAktif($query)
    {
        return $query
            ->where('status', 'aktif')
            ->where('is_current', true);
    }
}
