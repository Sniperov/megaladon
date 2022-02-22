<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'executor_id', 'order_id'];

    public function executor()
    {
        return $this->belongsTo(Executor::class, 'executor_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
