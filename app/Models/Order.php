<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'user_id', 'executor_id'];

    const STATUS_MODERATE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_HAS_EXECUTOR = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_ARCHIVE = 5;

    public function media()
    {
        return $this->hasMany(MediaFiles::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'order_id');
    }

    public function offers()
    {
        return $this->hasMany(OrderOffer::class, 'order_id');
    }
}
