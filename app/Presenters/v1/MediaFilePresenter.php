<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class MediaFilePresenter extends BasePresenter
{
    public function list()
    {
        return [
            'url' => url($this->storage_link),
            'active' => (boolean)$this->active
        ];
    }
}