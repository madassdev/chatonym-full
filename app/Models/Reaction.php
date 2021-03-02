<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use SoftDeletes;

    public static function modelColumnName()
    {
        return 'thread_message_id';
    } 

    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function threadMessage()
    {
        return $this->belongsTo(ThreadMessage::class);
    }
}
