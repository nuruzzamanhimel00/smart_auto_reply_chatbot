<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = ['id'];


    protected $casts = [
        'auto_reply_enabled' => 'boolean',
        'last_activity_at' => 'datetime'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class,'guest_id','id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id','id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'chat_id','id');
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class,'chat_id','id')->latestOfMany();
    }

    public function hasAgent()
    {
        return !is_null($this->agent_id);
    }

    public function shouldAutoReply()
    {
        return $this->auto_reply_enabled && !$this->hasAgent();
    }
}
