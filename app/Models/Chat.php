<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['image_url'=>"array", "is_sender"=>"boolean"];

    protected $appends = ['is_sender'];

    public function message_model()
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }

    public function getIsSenderAttribute()
    {
        if($this->message_model->user_id == auth()->user()->id){

            return !$this->sent_by_anon ? true : false;
        }else{
            return $this->sent_by_anon ? true : false;
        }
    }
}
