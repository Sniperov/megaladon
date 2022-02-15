<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class UserPresenter extends BasePresenter
{
    public function profile()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo_url' => $this->photo_url ? url($this->photo_url) : null,
            'phone' => $this->phone,
            'city' => $this->city ? (new CityPresenter($this->city))->list() : null,
            'executor' => $this->executor ? (new ExecutorPresenter($this->executor))->edited() : null,
            'store' => $this->store ? (new StorePresenter($this->store))->detail() : null,
        ];
    }

    public function short()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo_url' => $this->photo_url ? url($this->photo_url) : null,
            // 'count_orders' => $this->count_orders,
            // 'rating' => $this->rating,
        ];
    }
}