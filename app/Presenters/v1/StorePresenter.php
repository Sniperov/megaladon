<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class StorePresenter extends BasePresenter
{
    public function detail()
    {
        return [
            'type' => ['id' => $this->type_id, 'name' => $this->type->name],
            'name' => $this->name,
            'bin' => $this->bin,
            'city' => ['id' => $this->city_id, 'name' => $this->city->name],
            'lat' => (double)$this->lat,
            'lon' => (double)$this->lon,
            'full_address' => $this->full_address,
            'photo_url' => $this->photo_url,
            'contacts' => $this->presentCollections($this->contacts, StoreContactsPresenter::class, 'info'),
        ];
    }

    public function list()
    {
        return [
            'type' => $this->type->name,
            'rating' => $this->rating,
            'full_address' => $this->full_address,
            'photo_url' => $this->photo_url,
        ];
    }
}