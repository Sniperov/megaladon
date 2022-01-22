<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UpdateProfileRequest;
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
}