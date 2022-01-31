<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class ServiceTypePresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}