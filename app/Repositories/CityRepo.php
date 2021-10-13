<?php

namespace App\Repositories;

use App\Models\City;

class CityRepo
{
    public function getAll()
    {
        return City::all();
    }
}