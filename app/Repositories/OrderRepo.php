<?php

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
        return $order->update($data);
    }

    public function index($params)
    {
        $query = Order::with('media', 'category');
        $query = $this->applyFilterQuery($query, $params);           
        $query = $this->applyPaginationQuery($query, $params);
        return $query->get();
    }

    private function applyFilterQuery($query, $params)
    {
        $query->when($params['category_id'], function ($query) use ($params) {
            return $query->where('category_id', $params['category_id']);
        })
        ->when($params['status'], function ($query) use ($params) {
            return $query->whereIn('status', $params['status']);
        });

        return $query;
    }

    private function applyPaginationQuery($query, $params)
    {
        if ($params['startRow']) {
            $query->skip($params['startRow']);
        }
        if ($params['rowsPerPage']) {
            $query->take($params['rowsPerPage']);
        } else {
            $query->take(100);
        }
        return $query;
    }
}