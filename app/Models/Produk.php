<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'desa_id',
        'nama_produk',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'foto',
        'kategori',
        'asal_desa',
        'kontak',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($produk) {
            $produk->slug = Str::slug($produk->nama_produk);
        });

        static::updating(function ($produk) {
            $produk->slug = Str::slug($produk->nama_produk);
        });
    }
}
