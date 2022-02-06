<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class AdvertPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => mb_strimwidth($this->description, 0 , 128, '...'),
            'price' => (double) $this->price,
            'media' => $this->presentCollections($this->media, MediaFilePresenter::class, 'list'),
            'created_at' => $this->created_at,
        ];
    }

    public function info()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => (double) $this->price,
            'additional_phone' => $this->additional_phone,
            'media' => $this->presentCollections($this->media, MediaFilePresenter::class, 'list'),
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name, 
            ],
            'user' => (new UserPresenter($this->user))->short(),
            'created_at' => $this->created_at,
        ];
    }
}