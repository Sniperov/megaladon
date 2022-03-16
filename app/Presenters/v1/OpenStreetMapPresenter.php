<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class OpenStreetMapPresenter extends BasePresenter
{
    public function list()
    {
        $house_number = isset($this->model['address']['house_number']) ? $this->model['address']['house_number'] : '';
        $city = isset($this->model['address']['city'])? $this->model['address']['city'] : $this->model['address']['town'];
        return [
            'lat' => $this->model['lat'],
            'lon' => $this->model['lon'],
            'full_path' => 
                $this->model['address']['country'] . ', ' 
                . $city . ', '
                . $this->model['address']['road'] . ', '
                . $house_number,
        ];
    }
}