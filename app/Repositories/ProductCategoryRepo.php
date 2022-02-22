<?php

namespace App\Repositories;

use App\Models\ProductCategory;

class ProductCategoryRepo
{
    public function index()
    {
        ProductCategory::with('child')
            ->where('parent_id', 0)
            ->get();
    }
}