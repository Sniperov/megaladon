<?php

namespace App\Services\v1;

use App\Presenters\v1\SubscriptionPresenter;
use App\Repositories\SubscriptionRepo;
use App\Services\BaseService;

class SubscriptionService extends BaseService
{
    private SubscriptionRepo $subscriptionRepo;

    public function __construct() {
        $this->subscriptionRepo = new SubscriptionRepo();
    }

    public function index(array $params)
    {
        $subscriptions = $this->subscriptionRepo->index($params);
        return $this->resultCollections($subscriptions, SubscriptionPresenter::class, 'list');
    }
}