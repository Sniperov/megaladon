<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class CityPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'title' => $this->name, 
        ];
    }
}