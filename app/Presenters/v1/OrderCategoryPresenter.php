<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class OrderCategoryPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'child' => $this->presentCollections($this->child, OrderCategoryPresenter::class, 'list'),
        ];
    }
}