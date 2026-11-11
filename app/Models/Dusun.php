<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    use HasFactory;

    protected $table = 'dusun';

    protected $fillable = [
        'desa_id',
        'nama_dusun',
        'nama_kepdus',
        'no_wa',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
