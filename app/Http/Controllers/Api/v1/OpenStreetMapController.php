<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\OSMRequest;
use App\Services\v1\OpenStreetMapService;
use Illuminate\Http\Request;

class OpenStreetMapController extends ApiController
{
    protected OpenStreetMapService $service;

    public function __construct() {
        $this->service = new OpenStreetMapService();
    }

    public function getAddress(OSMRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->service->findAddress($data));
    }
}
