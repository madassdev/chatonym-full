<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use SoftDeletes;
    //
    
    protected $guarded = [
        'audio_url',
        'warped_audio_url',
        'warp_effect',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'image_url' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replier()
    {
        return $this->belongsTo(User::class, 'replier_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

}
