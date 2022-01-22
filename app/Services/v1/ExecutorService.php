<?php

namespace App\Services\v1;

use App\Repositories\ExecutorRepo;
use App\Services\BaseService;

class ExecutorService extends BaseService
{
    private ExecutorRepo $executorRepo;

    public function __construct() {
        $this->executorRepo = new ExecutorRepo();
    }

    public function store(array $data)
    {
        $user = auth('api')->user();
        if (is_null($user)) {
            return $this->errNotFound('Пользователь не найден');
        }
        if (!is_null($this->executorRepo->findByUserId($user->id))) {
            return $this->errValidate('Вы уже зарегистрированны как исполнитель');
        }
        $data['user_id'] = $user->id;

        return $this->result(['executor' => $this->executorRepo->store($data)]);
    }

    public function update(array $data)
    {
        $user = auth('api')->user();

        if (is_null($user)) {
            return $this->errNotFound('Пользователь не найден');
        }

        $executor = $this->executorRepo->findByUserId($user->id);

        if (is_null($executor)) {
            return $this->errValidate('Вы не зарегистрированны как исполнитель');
        }

        return $this->executorRepo->update($user->id, $data);
    }
}