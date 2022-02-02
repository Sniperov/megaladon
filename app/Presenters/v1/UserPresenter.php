<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class UserPresenter extends BasePresenter
{
    public function profile()
    {
        return [
            'name' => $this->name,
            'photo_url' => url($this->photo_url),
            'phone' => $this->phone,
            'executor' => $this->executor ? (new ExecutorPresenter($this->executor))->edited() : null,
            'store' => $this->store ? (new StorePresenter($this->store))->detail() : null,
        ];
    }

    public function offer()
    {
        return [
            'name' => $this->name,
            'photo_url' => url($this->photo_url),
            'count_orders' => $this->count_orders,
            'rating' => $this->rating,
        ];
    }
}