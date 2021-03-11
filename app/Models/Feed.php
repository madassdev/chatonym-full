<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use ErrorException;

class Feed extends Model
{
    use SoftDeletes;

    public $reactionClass = FeedReaction::class;
    
    protected $appends = [
        'replies',
        'reacted_by_user'
    ];
    protected $guarded = [
        'audio_url',
        'warped_audio_url',
        'warp_effect',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = ['reactions'];

    protected $casts = [
        'image_url' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(FeedReaction::class);
    }

    public static function getComments($parent_id)
    {
       return Feed::where('parent_id', $parent_id);
    }

    public function replies()
    {
        return $this->hasMany(Feed::class, 'parent_id', 'id')->orderBy('created_at', 'DESC');
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


}
