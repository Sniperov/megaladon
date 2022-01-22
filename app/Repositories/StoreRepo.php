<?php 
namespace App\Repositories;

use App\Models\Store;

class StoreRepo
{
    public function store(array $data) : Store
    {
        return Store::create($data);
    }
}