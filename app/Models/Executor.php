<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Executor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'type_id',
        'name',
        'bin',
        'city_id',
        'lat',
        'lon',
        'full_address',
    ];

    public function services()
    {
        return $this->belongsToMany(ServiceType::class, 'executor_service_types');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function type()
    {
        return $this->belongsTo(CompanyType::class, 'type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
