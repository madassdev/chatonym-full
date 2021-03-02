<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use ErrorException;

class ThreadMessage extends Model
{
    use SoftDeletes;

    public $reactionClass = Reaction::class;
    
    protected $appends = [
        'replies',
        'total_reactions',
        'reacted_by_user'
    ];
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

    protected $hidden = ['reactions'];


    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public static function getComments($parent_id)
    {
       return ThreadMessage::where('parent_id', $parent_id);
    }

    public function replies()
    {
        return $this->hasMany(ThreadMessage::class, 'parent_id', 'id');
    }

    public function getRepliesAttribute()
    {
        return $this->replies()->count();
    }


    public function getReactedByUserAttribute()
    {

        try{
             if(isset(auth()->guard('api')->user()->id))
         {
             $userId = auth()->guard("api")->user()->id;


            $reaction = $this->reactions->
            first(function ($reac) use ($userId) {
                return $reac->user_id === $userId;
            });

            if ($reaction) {
                return $reaction;
            }
            else{
                return null;
            }
        }

        } catch(ErrorException $e){
            return null;
        }


        return null;
    }

    public function getTotalReactionsAttribute()
    {
        return $this->reactions->count();
    }

}
