<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class ExecutorPresenter extends BasePresenter
{
    public function edited()
    {
        return [
            'id' => $this->id,
            'services' => $this->presentCollections($this->services, ServiceTypePresenter::class, 'list'),
            "city" => !is_null($this->city) ? [
                'id' => $this->city->id,
                'name' => $this->city->name,
            ] : null,
            'name' => $this->name,
            'bin' => $this->bin ?? null,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'full_address' => $this->full_address,
            'rating' => $this->rating ?? null,
        ];
    }

    public function short()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rating' => $this->rating
        ];
    }
}