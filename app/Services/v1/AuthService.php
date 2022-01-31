<?php

namespace App\Services\v1;

use App\Models\User;
use App\Repositories\ExecutorRepo;
use App\Repositories\PhoneConfirmationRepo;
use App\Repositories\StoreRepo;
use App\Services\BaseService;
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
        $user = $this->userRepo->getUserByPhone($data['phone']);
        if (is_null($user)) {
            return $this->errNotFound('Неверные номер пользователя или пароль');
        }

        if ($user->is_phone_confirmed == 0) {
            return $this->error(406, 'Сначала подтвердите номер телефона');
        }
        
        if (! $token = auth('api')->attempt($data)) {
            return $this->error(401, 'Неверные номер пользователя или пароль');
        }

        return $this->result([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function register(array $data) : array
    {
        if ($this->userRepo->getUserByPhone($data['phone'])) {
            return $this->errValidate('Пользователь с таким номером существует');
        }

        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepo->store($data);
        (new PhoneConfirmationService())->sendCode($user, $data['phone']);

        return $this->result([
            'user' => $user,
        ]);
    }

    public function registerExecutor(array $data)
    {
        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->error(403, 'Auth error');
        }
        $data['user_id'] = $user->id;

        $executor = (new ExecutorRepo())->store($data);

        return $this->result([
            'user' => $user,
            'executor' => $executor,
        ]);
    }

    public function registerStore(array $data)
    {
        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->error(403, 'Auth error');
        }
        $data['user_id'] = $user->id;

        $store = (new StoreRepo())->store($data);

        return $this->result([
            'user' => $user,
            'store' => $store,
        ]);
    }

    public function confirmCode(array $data) : array
    {
        $code = (new PhoneConfirmationRepo())->getByPhone($data['phone']);

        if (!$code) {
            return $this->errNotFound('Номер телефона не корректен');
        }

        if ($code->code != $data['code']) {
            return $this->error(400, 'Код подтверждения указан неверно');
        }

        $user = $this->userRepo->confirmPhone($data['phone']);
        $token = auth('api')->login($user);

        return $this->result([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout()
    {
        auth('api')->logout();
        return $this->ok();
    }
}