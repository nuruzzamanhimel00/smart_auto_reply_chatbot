<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'last_seen_at' => 'datetime'
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class,'guest_id','id');
    }

    public function messages()
    {
        return $this->morphMany(Message::class, 'senderable');

    }

    public function activeChat()
    {
        return $this->hasOne(Chat::class)
            ->where('status', '!=', 'closed')
            ->latest();
    }
}
