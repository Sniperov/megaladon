<?php

namespace App\Presenters\v1;

use App\Services\BaseService;

class UserPresenter extends BaseService
{
    public function profile()
    {
        return [
            'name' => $this->name,
            'photo_url' => $this->photo_url,
            'phone' => $this->phone,
            'executor' => (new ExecutorPresenter($this->executor))->detail(),
            'store' => (new StorePresenter($this->store))->detail(),
        ];
    }

    public function offer()
    {
        return [
            'name' => $this->name,
            'photo_url' => $this->photo_url,
            'count_orders' => $this->count_orders,
            'rating' => $this->rating,
        ];
    }
}