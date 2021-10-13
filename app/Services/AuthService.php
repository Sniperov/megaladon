<?php

namespace App\Services;

use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;

class AuthService extends BaseService
{
    private UserRepo $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepo();
    }

    public function login(array $data) : array
    {
        if (!$this->userRepo->getUserByPhone($data['phone'])) {
            return $this->errNotFound('Пользователь с таким телефоном не найден');
        }
        
        if (! $token = auth()->attempt($data)) {
            return $this->error(401, 'Unauthorized');
        }

        return $this->result(['token' => $token]);
    }

    public function register(array $data) : array
    {
        if ($this->userRepo->getUserByPhone($data['phone'])) {
            return $this->errValidate('Пользователь с таким номером существует');
        }
        $password = $data['password'];
        $data['password'] = Hash::make($data['password']);

        //TODO: Сделать подтверждение смс

        $user = $this->userRepo->store($data);
        // $token = auth()->attempt(['phone' => $data['phone'], 'password' => $password]);
        $token = auth()->login($user);

        return $this->result([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return $this->ok();
    }
}