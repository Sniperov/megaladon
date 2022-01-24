<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\IndexStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Services\v1\StoreService;
use Illuminate\Http\Request;

class StoreController extends ApiController
{
    private StoreService $storeService;

    public function __construct() {
        $this->storeService = new StoreService();
    }

    public function updateProfile(UpdateStoreRequest $request)
    {
        $data = $request->validated();
        return $this->storeService->updateProfile($this->authUser(), $data);
    }

    public function index(IndexStoreRequest $request)
    {
        $params = $request->validated();
        return $this->storeService->index($params);
    }
}
