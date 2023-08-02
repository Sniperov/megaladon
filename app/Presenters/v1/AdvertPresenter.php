<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class AdvertPresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'price' => number_format($this->price, 2),
            'media' => $this->presentCollections($this->media, MediaFilePresenter::class, 'list'),
            'created_at' => $this->created_at,
        ];
    }

    public function info()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'price' => number_format($this->price, 2),
            'additional_phone' => $this->additional_phone,
            'media' => $this->presentCollections($this->media, MediaFilePresenter::class, 'list'),
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name, 
            ],
            
            'user' => (new UserPresenter($this->user))->shortAdvert(),
            'created_at' => $this->created_at,
        ];
    }

    public function categories()
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'child' => $this->presentCollections($this->child, AdvertPresenter::class, 'categories'),
        ];
    }
}