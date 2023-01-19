<?php

namespace App\Repositories;

use App\Models\CompanyType;

class CompanyRepo
{
    public function index()
    {
        return CompanyType::all('id', 'title');
    }
}