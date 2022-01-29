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

    public function getStatusName() : string
    {
        switch ($this->status) {
            case self::STATUS_MODERATE:
                return 'На проверке';
            case self::STATUS_ACTIVE:
                return 'Активный';
            case self::STATUS_HAS_EXECUTOR:
                return 'В работе';
            case self::STATUS_COMPLETED:
                return 'Выполнен';
            case self::STATUS_ARCHIVE:
                return 'В архиве';
        }
        return '';
    }
}
