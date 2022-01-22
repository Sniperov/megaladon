<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Services\v1\CityService;
use Illuminate\Http\Request;

class CityController extends ApiController
{
    private CityService $cityService;

    public function __construct() {
        $this->cityService = new CityService();
    }

    public function getAll()
    {
        $response = $this->cityService->getAll();
        return $this->result($response);
    }
}
