<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class OfferPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id'=> $this->id,
            'description' => $this->description,
            'date' => $this->date,
            'price' => $this->price,
            'user' => (new UserPresenter($this->user))->short(),
        ];
    }

    public function info()
    {
        return [
            'id'=> $this->id,
            'description' => $this->description,
            'date' => $this->date,
            'price' => $this->price,
            'expire_at' => $this->expire_at,
            'user' => (new UserPresenter($this->user))->short(),
        ];
    }
}