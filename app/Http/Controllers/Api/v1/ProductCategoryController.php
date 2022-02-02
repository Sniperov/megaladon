<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Repositories\ProductCategoryRepo;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    private ProductCategoryRepo $categoryRepo;

    public function __construct() {
        $this->categoryRepo = new ProductCategoryRepo();
    }

    public function index()
    {
        $productCategories = $this->categoryRepo->index();
        return $this->result(['categories' => $productCategories]);
    }
}
