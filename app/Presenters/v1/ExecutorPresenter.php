<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class ExecutorPresenter extends BasePresenter
{
    public function edited()
    {
        return [
            'id' => $this->id,
            'type' => !is_null($this->type) ? [
                'id' =>  $this->type->id,
                'name' => $this->type->title,
            ] : null,
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
            'type' => !is_null($this->type) ? [
                'id' =>  $this->type->id,
                'name' => $this->type->title,
            ] : null,
            'name' => $this->name,
            'rating' => $this->rating
        ];
    }
}