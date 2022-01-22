<?php

namespace App\Services\v1;

use App\Models\User;
use App\Repositories\UserRepo;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService extends BaseService
{
    private UserRepo $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepo();
    }

    public function updateProfile(User $user, $data)
    {
        $updatedUser = $this->userRepo->update($user->id, $data);
        return $this->result(['user' => $updatedUser]);
    }
    
    public function resetPassword(User $user)
    {
        $newPassword = Str::random(8);
        //send sms with password
        $this->userRepo->update($user->id, ['password' => Hash::make($newPassword)]);
        return $this->ok();
    }
}