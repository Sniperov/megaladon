<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class OrderPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => mb_strimwidth($this->description, 0, 128, "..."),
            'count_offers' => $this->countOffers(),
            'city' => (new CityPresenter($this->city))->list(),
            'created_at' => date('d.m.Y', strtotime($this->created_at)),
            'status' => $this->getStatusName(), 
            'status_code' => $this->status,
        ];
    }

    public function detail()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->getStatusName(),
            'status_code' => $this->status,
            'count_offers' => $this->countOffers(),
            'category' => $this->category ? [
                'id' => $this->category->id,
                'title' => $this->category->title, 
            ] : null,
            'city' => (new CityPresenter($this->city))->list(),
            'user' => $this->user ? (new UserPresenter($this->user))->short() : null,
            'executor' => $this->executor ? (new ExecutorPresenter($this->executor))->short() : null,
            'files' => $this->media ? $this->presentCollections($this->media, MediaFilePresenter::class, 'list') : [],
        ];
    }
}