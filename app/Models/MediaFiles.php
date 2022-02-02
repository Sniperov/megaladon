<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFiles extends Model
{
    use HasFactory;

    protected $fillable = ['storage_link', 'active'];

    public function mediable()
    {
        return $this->morphTo('mediable');
    }
}
