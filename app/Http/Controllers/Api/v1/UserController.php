<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\EndChangePhoneRequest;
use App\Http\Requests\User\ChangePhoneRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UpdateTokenRequest;
use App\Services\v1\UserService;
use Illuminate\Support\Facades\Request;

class UserController extends ApiController
{
    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $response = $this->userService->updateProfile($this->authUser(), $data);
        return $this->result($response);
    }

    public function resetPassword()
    {
        $response = $this->userService->resetPassword($this->authUser());
        return $this->result($response);
    }

    public function startChangePhone(ChangePhoneRequest $request)
    {
        $data = $request->validated();
        $response = $this->userService->startChangePhone($data);
        return $this->result($response);
    }

    public function endChangePhone(EndChangePhoneRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->userService->endChangePhone($data));
    }

    public function updateToken(UpdateTokenRequest $request)
    {
        return $this->result($this->userService->updateToken($request->validated()));
    }

    public function disableNotifications()
    {
        return $this->result($this->userService->disableNotifications());
    }
}