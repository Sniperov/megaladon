<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreContacts extends Model
{
    use HasFactory;

    protected $fillable = ['store_id', 'type', 'contact_name', 'value'];
}
