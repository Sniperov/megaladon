<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
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

    public function contacts()
    {
        return $this->hasMany(StoreContacts::class, 'store_id');
    }
}
