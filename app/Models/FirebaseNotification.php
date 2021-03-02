<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirebaseNotification extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'token',
        'device'
    ];
    
}
