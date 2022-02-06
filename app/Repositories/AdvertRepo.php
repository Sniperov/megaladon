<?php

namespace App\Repositories;

use App\Models\Advert;

class AdvertRepo
{
    public function info(int $id)
    {
        return Advert::with('user', 'category', 'media')
            ->find($id);
    }

    public function index(array $params)
    {
        $query = Advert::with('media');
        $query = $this->applyFilterQuery($query, $params);           
        $query = $this->applyPaginationQuery($query, $params);
        return $query->get();
    }

    public function store(array $data)
    {
        return Advert::create($data);
    }

    public function update(int $id, array $data)
    {
        return Advert::where('id', $id)
            ->update($data);
    }

    private function applyFilterQuery($query, $params)
    {
        if (isset($params['category'])) {
            $query->where('category_id', $params['category']);
        }

        if(isset($params['city_id'])) {
            $query->where('city_id', $params['city_id']);
        }

        if(isset($params['price_min'])) {
            $query->where('price', '>', $params['price_min']);
        }

        if(isset($params['price_max'])) {
            $query->where('price', '<', $params['price_max']);
        }

        return $query;
    }

    private function applyPaginationQuery($query, $params)
    {
        if (isset($params['startRow'])) {
            $query->skip($params['startRow']);
        }
        if (isset($params['rowsPerPage'])) {
            $query->take($params['rowsPerPage']);
        } else {
            $query->take(100);
        }
        return $query;
    }
}