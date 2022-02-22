<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Services\v1\ProductCategoryService;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    private ProductCategoryService $serivce;

    public function __construct() {
        $this->serivce = new ProductCategoryService();
    }

    public function index()
    {
        return $this->result($this->serivce->index());
    }
}
