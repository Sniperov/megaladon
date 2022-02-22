<?php

namespace App\Services\v1;

use App\Events\ExecutorRatedEvent;
use App\Http\Requests\Order\CommentOrderRequest;
use App\Models\Executor;
use App\Models\Order;
use App\Models\OrderOffer;
use App\Models\User;
use App\Presenters\v1\ExecutorPresenter;
use App\Presenters\v1\OfferPresenter;
use App\Presenters\v1\OrderPresenter;
use App\Repositories\CommentRepo;
use App\Repositories\ExecutorRepo;
use App\Repositories\OrderOfferRepo;
use App\Repositories\OrderRepo;
use App\Services\BaseService;
use Illuminate\Support\Facades\Storage;

class OrderService extends BaseService
{
    private OrderRepo $orderRepo;

    public function __construct() {
        $this->orderRepo = new OrderRepo();
    }

    public function create(User $user, $data)
    {
        $data['user_id'] = $user->id;
        $data['executor_id'] = 0;
        $data['status'] = Order::STATUS_MODERATE;
        $order = $this->orderRepo->store($data);

        if (isset($data['files'])) {
            foreach($data['files'] as $file) {
                $path = $file->store('public/order/'.$order->id);
                $order->media()->create([
                    'storage_link' => Storage::url($path), 
                ]);
            }
        }

        return $this->result([
            'order' => (new OrderPresenter($order))->detail(),
        ]);
    }

    public function createOffer(User $user, array $data, int $orderId)
    {
        $offerRepo = new OrderOfferRepo();

        $offer = $offerRepo->getByUserIdAndOrderId($orderId, $user->id);

        if (!is_null($offer)) {
            return $this->error(406, 'Вы уже откликались на этот заказ');
        }

        $data['order_id'] = $orderId;
        $data['user_id'] = $user->id;

        $offerRepo->store($data);

        return $this->ok('Предложение отправленно');
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
        $order->media()->delete();

        if (isset($data['files'])) {
            foreach($data['files'] as $file) {
                $path = $file->store('public/order/'.$order->id);
                $order->media()->create([
                    'storage_link' => Storage::url($path), 
                ]);
            }
        }
        unset($data['files']);

        $this->orderRepo->update($order, $data);

        return $this->ok('Заказ сохранён');
    }

    public function index($params)
    {
        $orders = $this->orderRepo->index($params);

        return $this->resultCollections($orders, OrderPresenter::class, 'list');
    }

    public function indexMy(array $params)
    {
        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->errFobidden('Ошибка авторизации');
        }
        $params['user_id'] = $user->id;
        $orders = $this->orderRepo->index($params);
        return $this->resultCollections($orders, OrderPresenter::class, 'list');
    }

    public function info($id)
    {
        $order = Order::with('media', 'category')->find($id);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }
        return $this->result([
            'order' => (new OrderPresenter($order))->detail(),
        ]);
    }

    public function getOffers($orderId): array
    {
        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->error(401, 'Unauthorized');
        }
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
        $order = Order::find($orderId);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->errFobidden('Требуется авторизация');
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

    public function delete(int $orderId)
    {
        $order = Order::find($orderId);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->errFobidden('Требуется авторизация');
        }

        if ($order->user_id != $user->id) {
            return $this->error(406, 'Вы не можете удалить чужой заказ');
        }

        $this->orderRepo->update($order, ['status' => Order::STATUS_ARCHIVE]);

        return $this->ok();
    }

    public function complete(int $orderId)
    {
        $order = Order::find($orderId);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->errFobidden('Требуется авторизация');
        }

        if ($order->user_id != $user->id) {
            return $this->error(406, 'Вы не можете завершить чужой заказ');
        }

        if ($order->status !== Order::STATUS_HAS_EXECUTOR) {
            return $this->error(406, 'Чтобы завершить заказ он должен иметь статус "В работе"');
        }

        $this->orderRepo->update($order, ['status' => Order::STATUS_COMPLETED]);

        return $this->ok();
    }

    public function accept(int $orderId, int $offerId)
    {
        $order = Order::find($orderId);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->errFobidden('Требуется авторизация');
        }
        
        $offer = OrderOffer::find($offerId);
        if (is_null($offer)) {
            return $this->errNotFound('Предложение не найдено');
        }

        if ($order->user_id != $user->id) {
            return $this->error(406, 'Вы не можете принять предложение чужого заказа');
        }

        $this->orderRepo->update($order, [
            'status' => Order::STATUS_HAS_EXECUTOR,
            'executor_id' => $offer->user_id,
        ]);

        return $this->ok();
    }

    public function rateExecutor(int $orderId, float $rate)
    {
        $order = Order::find($orderId);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }
        
        $user = $this->apiAuthUser();
        if (is_null($user)) {
            return $this->errFobidden('Требуется авторизация');
        }

        if ($order->user_id != $user->id) {
            return $this->error(406, 'Вы не можете оценить исполнителя чужого заказа');
        }
        
        if ($order->status !== Order::STATUS_COMPLETED) {
            return $this->error(406, 'Вы пока не можете оценить исполнителя');
        }

        $executor = Executor::find($order->executor_id);
        if (is_null($executor)) {
            return $this->errNotFound('Исполнитель не найден');
        }

        $executor->rating()->create([
            'user_id' => $user->id,
            'rate' => $rate,
        ]);

        event(new ExecutorRatedEvent($executor));

        return $this->ok();
    }

    public function createChat(int $orderId)
    {
        $order = Order::find($orderId);
        if (is_null($order)) {
            return $this->errNotFound('Заказ не найден');
        }

        if ($order->status !== Order::STATUS_HAS_EXECUTOR) {
            return $this->error(406, 'Вы не можете создать чат без исполнителя');
        }

        $iniciator = $this->apiAuthUser();
        if (is_null($iniciator)) {
            return $this->errFobidden('Ошибка авторизации');
        }

        $order->chatable()->create([
            'iniciator_id' => $iniciator->id,
            'user_id' => $order->executor_id,
        ]);

        return $this->ok();
    }
}