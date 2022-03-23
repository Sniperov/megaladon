<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = ['chat_id', 'user_id', 'message', 'file_url'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
