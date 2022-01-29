<?php

namespace App\Services\v1;

use App\Models\Store;
use App\Models\User;
use App\Presenters\v1\StorePresenter;
use App\Repositories\StoreRepo;
use App\Services\BaseService;

class StoreService extends BaseService
{
    private StoreRepo $storeRepo;

    public function __construct() {
        $this->storeRepo = new StoreRepo();
    }

    public function updateProfile(User $user, array $data) : array
    {
        $store = $this->storeRepo->getByUserId($user->id);
        if (is_null($store)) {
            return $this->errNotFound('Магазин не найден');
        }

        $this->storeRepo->update($store->id, $data);

        return $this->ok('Данные магазина обновленны');
    }

    public function index(array $params)
    {
        $stores = $this->storeRepo->index($params);
        $count = $this->storeRepo->count($params);
        return $this->resultCollections($stores, StorePresenter::class, 'list', $count);
    }

    public function info($id)
    {
        $store = Store::with('contacts')->find($id);

        if (is_null($store)) {
            return $this->errNotFound('Магазин не найден');
        }

        return $this->result(['store' => (new StorePresenter($store))->detail()]);
    }
}