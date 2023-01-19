<?php

namespace App\Services\v1;

use App\Presenters\v1\ServiceTypePresenter;
use App\Repositories\ServiceTypeRepo;
use App\Services\BaseService;

class ServiceTypeService extends BaseService
{
    public function index()
    {
        $collections = (new ServiceTypeRepo())->index();
        return $this->resultCollections($collections, ServiceTypePresenter::class, 'list');
    }
}