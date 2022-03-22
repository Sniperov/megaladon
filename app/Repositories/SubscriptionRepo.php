<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepo
{
    public function index(array $params)
    {
        $query = Subscription::query();
        $query = $this->applyFilter($query, $params);
        
        return $query->get();
    }

    private function applyFilter($query, array $params)
    {
        if (isset($params['type'])) {
            $query->where('type', $params['type']);
        }

        return $query;
    }
}