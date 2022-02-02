<?php

namespace App\Services\v1;

use App\Models\OrderCategory;
use App\Presenters\v1\OrderCategoryPresenter;
use App\Services\BaseService;

class CatalogService extends BaseService
{
    public function orderCategories()
    {
        $categories = OrderCategory::with('child')->where('parent_id', 0)->get();
        return $this->resultCollections($categories, OrderCategoryPresenter::class, 'list');
    }
}