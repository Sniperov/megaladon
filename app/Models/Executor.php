<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Executor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'name',
        'bin',
        'lat',
        'lon',
        'full_address',
        'rating',
    ];

    public function services()
    {
        return $this->belongsToMany(ServiceType::class, 'executor_service_types');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rating()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }
}
