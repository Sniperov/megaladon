<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCategory extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'parent_id'];

    public function child()
    {
        return $this->hasMany(OrderCategory::class, 'parent_id');
    }
}
