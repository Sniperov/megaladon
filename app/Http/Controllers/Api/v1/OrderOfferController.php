<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateOrderOfferRequest;
use Illuminate\Http\Request;
use App\Services\v1\OrderService;

class OrderOfferController extends ApiController
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function create($id, CreateOrderOfferRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->orderService->createOffer($this->authUser(), $data));
    }

    public function orderOffers($id)
    {
        return $this->result($this->orderService->getOffers($id, $offerId));
    }

    public function info($id, $offerId)
    {
        return $this->result($this->orderService->infoOffer($id, $offerId));
    }
}
