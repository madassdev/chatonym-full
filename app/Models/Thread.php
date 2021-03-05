<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use ErrorException;
use IFrankSmith\Sluggable\Traits\Sluggable;

class Thread extends Model
{
    use SoftDeletes, Sluggable;

    public $reactionClass = ThreadReaction::class;
    
    protected $appends = [
        'reacted_by_user'
    ];

    protected $guarded = [];

    protected $hidden = ['secret'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(ThreadMessage::class);
    }

    public function reactions()
    {
        return $this->hasMany(ThreadReaction::class);
    }

    public static function slugTaken($slug)
    {
        if(Thread::withTrashed()->whereSlug($slug)->first()){
            return true;
        }
        return false;
    }

    public function getRouteKeyName()
    {
        return 'slug';
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

    public function sluggable()
    {
        return [
            "source" => "name",
            "column" => "slug",
        ];
    }

}
