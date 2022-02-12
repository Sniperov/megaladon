<?php

namespace App\Presenters\v1;

use App\Presenters\BasePresenter;

class MediaFilePresenter extends BasePresenter
{
    public function list()
    {
        return [
            'id' => $this->id,
            'url' => url($this->storage_link),
            'active' => (boolean)$this->active
        ];
    }
}