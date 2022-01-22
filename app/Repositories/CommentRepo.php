<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepo
{
    public function store($data)
    {
        return Comment::create($data);
    }
}