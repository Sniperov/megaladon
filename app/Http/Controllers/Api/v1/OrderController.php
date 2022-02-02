<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Order\{
    CommentOrderRequest,
    CreateOrderRequest,
    IndexOrderRequest,
    UpdateOrderRequest,
};
use App\Services\v1\OrderService;

class OrderController extends ApiController
{
    private OrderService $orderService;

    public function __construct() {
        $this->orderService = new OrderService();
    }

    public function store(CreateOrderRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->orderService->create($this->authUser(), $data));
    }

    public function update($id, UpdateOrderRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->orderService->update($id, $data));
    }

    public function index(IndexOrderRequest $request)
    {
        $params = $request->validated();
        return $this->result($this->orderService->index($params));
    }

    public function info($id)
    {
        return $this->result($this->orderService->info($id));
    }
    
    public function commentOrder(CommentOrderRequest $request)
    {
        $data = $request->validated();
        return $this->result($this->orderService->commentOrder($data));
    }
}
