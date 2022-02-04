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

    public function getByUserIdAndOrderId(int $orderId, int $userId)
    {
        return OrderOffer::where('order_id', $orderId)
            ->where('user_id', $userId)
            ->first();
    }

    public function info($offerId)
    {
        return OrderOffer::with('user')
            ->find($offerId);
    }
}