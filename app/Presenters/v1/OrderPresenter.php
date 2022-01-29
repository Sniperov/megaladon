<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class OrderPresenter extends BasePresenter
{
    public function list()
    {
        return [

        ];
    }

    public function detail()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->getStatusName(),
            'status_code' => $this->status,
            'count_offers' => $this->countOffers(),
            'user' => $this->user,
            'executor' => $this->executor,
        ];
    }
}