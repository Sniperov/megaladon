<?php

namespace App\Repositories;

use App\Models\ServiceType;

class ServiceTypeRepo
{
    public function index()
    {
        return ServiceType::all('id', 'name');
    }
}