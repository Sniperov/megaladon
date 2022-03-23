<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Advert\CreateAdvertRequest;
use App\Http\Requests\Advert\IndexAdvertsRequest;
use App\Http\Requests\Advert\UpdateAdvertRequest;
use App\Http\Requests\Chat\CreateChatRequest;
use App\Services\v1\AdvertService;
use Illuminate\Http\Request;

class AdvertController extends ApiController
{
    private AdvertService $advertService;

    public function __construct()
    {
        $this->advertService = new AdvertService();
    }

    public function index(IndexAdvertsRequest $request)
    {
        $params = $request->validated();
        return $this->result($this->advertService->index($params));
    }

    public function info($id)
    {
        return $this->result($this->advertService->info($id));
    }

    public function create(CreateAdvertRequest $request)
    {
        return $this->result($this->advertService->create($request->validated()));
    }

    public function update($id, UpdateAdvertRequest $request)
    {
        return $this->result($this->advertService->update($id, $request->validated()));
    }

    public function delete($id)
    {
        return $this->result($this->advertService->delete($id));
    }

    public function createChat($id, CreateChatRequest $request)
    {
        return $this->result($this->advertService->createChat($id));
    }
}
