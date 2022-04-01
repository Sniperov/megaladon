<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class OpenStreetMapPresenter extends BasePresenter
{
    public function list()
    {
        $house_number = isset($this->model['address']['house_number']) ? $this->model['address']['house_number'] : '';
        $town = isset($this->model['address']['town']) ? $this->model['address']['town'] : '';
        $city = isset($this->model['address']['city']) ? $this->model['address']['city'] . ', ' : $town;
        $road = isset($this->model['address']['road']) ? $this->model['address']['road'] . ', ' : '';
        return [
            'lat' => $this->model['lat'],
            'lon' => $this->model['lon'],
            'full_path' => 
                $this->model['address']['country'] . ', ' 
                . $city
                . $road
                . $house_number,
        ];
    }
}