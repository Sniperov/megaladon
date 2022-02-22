<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Services\v1\CatalogService;
use App\Services\v1\CityService;

class CatalogController extends ApiController
{
    public function cities()
    {
        $response = (new CityService())->getAll();
        return $this->result($response);
    }

    public function orderCategories()
    {
        $response = (new CatalogService())->orderCategories();
        return $this->result($response);
    }

    public function productCategories()
    {
        return $this->result((new CatalogService())->productCategories());
    }
}