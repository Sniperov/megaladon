<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
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
