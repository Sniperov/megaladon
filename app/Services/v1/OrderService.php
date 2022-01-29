<?php

namespace App\Services\v1;

use App\Http\Requests\Order\CommentOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Presenters\v1\OfferPresenter;
use App\Presenters\v1\OrderPresenter;
use App\Repositories\CommentRepo;
use App\Repositories\OrderOfferRepo;
use App\Services\BaseService;

class OrderService extends BaseService
{
    private OrderRepo $orderRepo;

    public function __construct() {
        $this->orderRepo = new OrderRepo;
    }

    public function create(User $user, $data)
    {
        $data['user_id'] = $user->id;
        $data['executor_id'] = 0;
        $data['status'] = Order::STATUS_MODERATE;
        $order = $this->orderRepo->store($data);

        return $this->result([
            'order' => (new OrderPresenter($order))->detail(),
        ]);
    }

    public function createOffer(User $user, array $data)
    {
        $offerRepo = new OrderOfferRepo();
        $data['user_id'] = $user->id;

        return $this->result([
            'orderOffer' => (new OfferPresenter($offerRepo->store($data)))->info(),
        ]);
    }

    public function update(int $id, array $data)
    {
        $order = Order::find($id);

        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        $user = auth('api')->user();

        if ($order->user_id != $user->id) {
            return $this->error(403, 'Вы не можете редактировать чужой заказ');
        }

        $this->orderRepo->update($order, $data);
        return $this->ok('Заказ сохранён');
    }

    public function index($params)
    {
        $orders = $this->orderRepo->index($params);

        return $this->result([
            'orders' => $this->resultCollections($orders, OrderPresenter::class, 'list'),
        ]);
    }

    public function info($id)
    {
        $order = Order::with('media', 'category')->find($id);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }
        return $this->result([
            'order' => (new OrderPresenter($order))->details(),
        ]);
    }

    public function commentOrder($data)
    {
        $data['user_id'] = auth('api')->id();
        (new CommentRepo())->store($data);
        return $this->ok('Сообщение отправленно');
    }

    public function getOffers($orderId): array
    {
        $user = $this->apiAuthUser();
        $order = Order::find($orderId);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        if ($order->user_id != $user->id) {
            return $this->error(403, 'У вас нет доступа для просмотра предложений этого заказа');
        }

        $offerRepo = new OrderOfferRepo();

        return $this->resultCollections($offerRepo->getByOrderId($orderId), OfferPresenter::class, 'list');
    }

    public function infoOffer($orderId, $offerId)
    {
        $user = $this->apiAuthUser();
        $order = Order::find($orderId);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        if ($order->user_id != $user->id) {
            return $this->error(403, 'У вас нет доступа для просмотра предложений этого заказа');
        }

        $offerRepo = new OrderOfferRepo();
        $offer = $offerRepo->info($offerId);
        
        return $this->result([
            'offer' => (new OfferPresenter($offer))->info(),
        ]);
    }
}