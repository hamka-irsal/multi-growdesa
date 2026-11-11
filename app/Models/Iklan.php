<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Iklan extends Model
{
    use HasFactory;

    protected $fillable = [
        'desa_id',
        'image',
        'is_active',
    ];

    /**
     * Mengubah path gambar dari database
     * menjadi URL gambar yang dapat diakses.
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => $image
                ? asset('storage/' . $image)
                : null,
        );
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
