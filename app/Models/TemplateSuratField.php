<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateSuratField extends Model
{
    use HasFactory;

    protected $table = 'template_surat_fields';

    protected $fillable = [
        'desa_id',
        'template_surat_id',
        'field_key',
        'label',
        'tipe_input',
        'sumber_data',
        'sumber_field',
        'required',
        'options',
        'validasi',
        'urutan',
        'placeholder',
        'petunjuk',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'desa_id' => 'integer',
            'template_surat_id' => 'integer',
            'required' => 'boolean',
            'aktif' => 'boolean',
            'options' => 'array',
            'validasi' => 'array',
            'urutan' => 'integer',
        ];
    }

    /**
     * Desa pemilik konfigurasi field.
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    /**
     * Template yang memiliki field ini.
     */
    public function templateSurat(): BelongsTo
    {
        return $this->belongsTo(
            TemplateSurat::class,
            'template_surat_id'
        );
    }
}
