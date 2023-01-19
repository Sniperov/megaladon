<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Services\v1\ServiceTypeService;

class ServiceTypeController extends ApiController
{
    public function index()
    {
        return $this->result((new ServiceTypeService())->index());
    }
}
