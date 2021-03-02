<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ThreadReaction extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    public static function modelColumnName()
    {
        return 'thread_id';
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}