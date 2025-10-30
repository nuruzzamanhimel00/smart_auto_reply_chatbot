<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_auto_reply' => 'boolean'
    ];

    public function senderable(): MorphTo
    {
        return $this->morphTo();
    }

     public function chat()
    {
        return $this->belongsTo(Chat::class,'chat_id','id');
    }

    public function isFromGuest()
    {
        return $this->sender_type === 'guest';
    }

    public function isFromAgent()
    {
        return $this->sender_type === 'agent';
    }
    public function isFromSystem()
    {
        return $this->sender_type === 'system';
    }
}
