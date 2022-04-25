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
            'expired_at' => $this->expired_at,
            'user' => (new UserPresenter($this->user))->short(),
            'city' => (new CityPresenter($this->city))->list(),
        ];
    }

    public function info()
    {
        return [
            'id'=> $this->id,
            'description' => $this->description,
            'date' => $this->date,
            'price' => $this->price,
            'expired_at' => $this->expired_at,
            'user' => (new UserPresenter($this->user))->short(),
            'city' => (new CityPresenter($this->city))->list(),
        ];
    }
}