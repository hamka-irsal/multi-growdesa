<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'desa_id',
        'name',
        'slug'
    ];

    /**
     * beritas
     *
     * @return HasMany
     */
    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
