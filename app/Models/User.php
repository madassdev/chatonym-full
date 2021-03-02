<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'mobile', 'password', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class)->latest();
    }

    public function feed_reactions()
    {
        return $this->hasMany(FeedReaction::class);
    }

    public function thread_reactions()
    {
        return $this->hasMany(ThreadReaction::class);
    }

    public function deviceToken()
    {
        return $this->hasOne(FirebaseNotification::class);
    }

    public function getTokenAttribute()
    {
        return @$this->deviceToken->token;
    }

    public function reactToModel($model, $reaction)
    {

        $modelColumnName = $model->reactionClass::modelColumnName();
        
        $rxn = $model->reactionClass::whereUserId($this->id)
                        ->where($modelColumnName, $model->id)
                        ->first();
        if($rxn != null){
            $rxn->reaction = $reaction;
            if($rxn->save()){
                return $rxn->fresh();
            }

        }else{
            if($model->reactionClass::create([
                'user_id'=>$this->id,
                $modelColumnName=>$model->id,
                'reaction'=> $reaction
                ])){  
                    $model->increment('reactions_count');
                    return $model->fresh();
                }
            }

        return false;
    }

    public function hasReactedToModel($model, $reaction)
    {
        $modelColumnName = $model->reactionClass::modelColumnName();
        
        $reaction = $model->reactionClass::whereUserId($this->id)
                        ->whereReaction($reaction)
                        ->where($modelColumnName, $model->id)
                        ->first();
        
        return $reaction;
    }

    public function hasReactedAtAllToModel($model)
    {
        $modelColumnName = $model->reactionClass::modelColumnName();
        
        $reaction = $model->reactionClass::whereUserId($this->id)
                        ->where($modelColumnName, $model->id)
                        ->first();
        
        return $reaction;
    }

    public function deleteModelReaction($model)
    {
        $modelColumnName = $model->reactionClass::modelColumnName();
        
        $reaction = $model->reactionClass::whereUserId($this->id)
                        ->where($modelColumnName, $model->id)
                        ->first();
        if($reaction->forceDelete()){
            $model->decrement('reactions_count');
            return true;
        }
    }
}
