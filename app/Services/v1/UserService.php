<?php

namespace App\Services\v1;

use App\Models\User;
use App\Repositories\PhoneConfirmationRepo;
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

    public function startChangePhone($data)
    {
        $user = $this->apiAuthUser();
        if (!Hash::check($data['password'], $user->password)) {
            return $this->error(401, 'Не верный номер телефона');
        }
        (new PhoneConfirmationService())->sendCode($user, $data['new_phone']);

        return $this->ok();
    }

    public function endChangePhone($data)
    {
        $pcRepo = new PhoneConfirmationRepo();
        $user = $this->apiAuthUser();
        $phoneConfirmation = $pcRepo->getByUserIdAndPhone($user->id, $data['phone']);
        
        if (is_null($phoneConfirmation)) {
            return $this->errNotFound('Не удалось найти код подтверждения, попробуйте чуть позднее');
        }

        if ($phoneConfirmation->code != $data['code']) {
            return $this->error(406, 'Введен не верный код-подтверждения');
        }

        $this->userRepo->update($user->id, ['phone' => $data['phone']]);
        return $this->ok('Телефон изменён');
    }

    public function updateToken($token) : array
    {
        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->error(403, 'Пользователь не авторизован');
        }
        $data = [
            'device_token' => $token,
            'push_notifications' => 1,
        ];
        $this->userRepo->update($user->id, $data);

        return $this->ok();
    }

    public function disableNotifications()
    {
        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->error(403, 'Пользователь не авторизован');
        }
        $data = [
            'device_token' => '',
            'push_notifications' => 0,
        ];
        $this->userRepo->update($user->id, $data);

        return $this->ok();
    }
}