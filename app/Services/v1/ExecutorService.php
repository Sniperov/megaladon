<?php

namespace App\Services\v1;

use App\Presenters\v1\ExecutorPresenter;
use App\Repositories\ExecutorRepo;
use App\Services\BaseService;

class ExecutorService extends BaseService
{
    private ExecutorRepo $executorRepo;

    public function __construct() {
        $this->executorRepo = new ExecutorRepo();
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

        $executor->services()->sync($data['services']);
        unset($data['services']);
        $this->executorRepo->update($user->id, $data);

        return $this->result(['executor' => (new ExecutorPresenter($this->executorRepo->info($user->id)))->edited()]);
    }
}