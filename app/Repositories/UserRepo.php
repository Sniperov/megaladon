<?php

namespace App\Repositories;

use App\Models\User;

class UserRepo
{
    public function getUserByPhone($phone)
    {
        return User::where('phone', $phone)
            ->first();
    }

    public function store(array $data)
    {
        return User::create($data);
    }

    public function update($userId,array $data)
    {
        return User::where('id', $userId)->update($data);
    }

    public function getById(int $id) :? User
    {
        return User::with('executor', 'store')->find($id);
    }

    public function confirmPhone($phone)
    {
        return User::where('phone', $phone)
            ->update([
                'is_phone_confirmed' => true,
            ]);
    }
}