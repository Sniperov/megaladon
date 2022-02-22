<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['iniciator_id', 'user_id'];

    public function chatable()
    {
        return $this->morphTo('chatable');
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'chat_id', 'id')->lastestOfMany();
    }
}
