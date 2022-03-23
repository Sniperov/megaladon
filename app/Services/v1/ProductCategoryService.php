<?php

namespace App\Services\v1;

use App\Repositories\ProductCategoryRepo;
use App\Services\BaseService;

class ProductCategoryService extends BaseService
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