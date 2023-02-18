<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'photo_url',
        'password',
        'is_phone_confirmed',
        'city_id',
        'email',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function executor()
    {
        return $this->hasOne(Executor::class, 'user_id', 'id');
    }

    public function store()
    {
        return $this->hasOne(Store::class, 'user_id', 'id');
    }

    public function countCompletedOrders()
    {
        return $this->hasMany(Order::class, 'executor_id')
            ->where('status', Order::STATUS_COMPLETED)
            ->count();
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setPhotoUrlAttribute($value) {
        $path = $value->store('public/users');
        $this->attributes['photo_url'] = Storage::url($path);
    }
}
