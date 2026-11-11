<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aparat extends Model
{
    use HasFactory;
    protected $table = 'aparat';
    protected $fillable = [
        'desa_id',
        'user_id',
        'nama',
        'jabatan',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
