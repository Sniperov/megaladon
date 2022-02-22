<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class FavoritePresenter extends BasePresenter
{
    public function list()
    {
        return [
            'order' => (new OrderPresenter($this->order))->short(),
            'executor' => (new ExecutorPresenter($this->executor))->short()
        ];
    }
}