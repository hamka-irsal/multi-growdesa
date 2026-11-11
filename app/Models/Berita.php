<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'desa_id',
        'judul',
        'slug',
        'category_id',
        'deskripsi',
        'penulis',
        'tanggal_publish',
        'foto',
    ];

    protected $casts = [
        'tanggal_publish' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
