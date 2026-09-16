<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationHidden extends Model
{
    protected $table = 'notifications_hidden';

    protected $fillable = [
        'user_id',
        'type',
        'reference_id',
    ];
}