<?php

namespace App\Services\v1;

use App\Models\Store;
use App\Models\User;
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
        return $this->result([
            'list' => $this->storeRepo->index($params),
            'total_count' => $this->storeRepo->count($params),
        ]);
    }

    public function info($id)
    {
        $store = Store::with('contacts')->find($id);

        if (is_null($store)) {
            return $this->errNotFound('Магазин не найден');
        }

        return $this->result($store->toArray());
    }
}