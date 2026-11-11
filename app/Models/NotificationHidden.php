<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationHidden extends Model
{
    protected $table = 'notifications_hidden';

    protected $fillable = [
        'desa_id',
        'user_id',
        'type',
        'reference_id',
    ];

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }
}
