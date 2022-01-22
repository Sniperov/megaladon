<?php

namespace App\Repositories;

use App\Models\OrderOffer;

class OrderOfferRepo
{
    public function store(array $data)
    {
        return OrderOffer::create($data);
    }

    public function getByOrderId(int $orderId)
    {
        return OrderOffer::with('user')
            ->where('order_id', $orderId)
            ->get();
    }
}