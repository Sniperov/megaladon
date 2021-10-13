<?php

namespace App\Services;

use App\Repositories\CityRepo;

class CityService extends BaseService
{
    private CityRepo $cityRepo;

    public function __construct() {
        $this->cityRepo = new CityRepo();
    }

    public function getAll()
    {
        $cities = $this->cityRepo->getAll();
        return $this->result(['cities' => $cities]);
    }
}