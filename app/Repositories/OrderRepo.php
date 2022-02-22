<?php

namespace App\Repositories;

use App\Models\Order;
use function GuzzleHttp\Promise\queue;

class OrderRepo
{
    public function store($data)
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data)
    {
        return Order::where('id', $order->id)->update($data);
    }

    public function index($params)
    {
        $query = Order::query();
        $query = $this->applyFilterQuery($query, $params);           
        $query = $this->applyPaginationQuery($query, $params);
        $query = $this->applySortBy($query, $params);
        return $query->get();
    }

    private function applyFilterQuery($query, $params)
    {
        if (isset($params['category'])) {
            $query->where('category_id', $params['category']);
        }

        if (isset($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (isset($params['user_id'])) {
            $query->where('user_id', $params['user_id']);
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

    public function applySortBy($query, $params)
    {
        $desc = 'ASC';

        if (isset($params['desc'])) {
            $desc = (boolean)$params['desc'] ? 'DESC' : 'ASC';
        }

        if (isset($params['sortBy'])) {
            $query->orderBy($params['sortBy'], $desc);
        }

        return $query;
    }
}