<?php

namespace App\Http\Controllers;

use App\Repositories\ProductCategoryRepo;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    private ProductCategoryRepo $categoryRepo;

    public function __construct() {
        $this->categoryRepo = new ProductCategoryRepo();
    }

    public function index()
    {
        return $this->result(['categories' => $this->categoryRepo->index()]);
    }
}
