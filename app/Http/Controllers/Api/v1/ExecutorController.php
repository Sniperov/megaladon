<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Executor\ExecutorUpdateRequest;
use App\Services\v1\ExecutorService;
use Illuminate\Http\Request;

class ExecutorController extends ApiController
{
    private ExecutorService $executorService;

    public function __construct() {
        $this->executorService = new ExecutorService();
    }

    public function update(ExecutorUpdateRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->executorService->store($data));
    }
}
