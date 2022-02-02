<?php

namespace App\Services\v1;

use App\Presenters\v1\CityPresenter;
use App\Repositories\CityRepo;
use App\Services\BaseService;

class CityService extends BaseService
{
    private CityRepo $cityRepo;

    public function __construct() {
        $this->cityRepo = new CityRepo();
    }

    public function getAll()
    {
        $cities = $this->cityRepo->getAll();
        return $this->resultCollections($cities, CityPresenter::class, 'list');
    }
}