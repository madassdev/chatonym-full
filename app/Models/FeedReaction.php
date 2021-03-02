<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FeedReaction extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    public static function modelColumnName()
    {
        return 'feed_id';
    } 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
