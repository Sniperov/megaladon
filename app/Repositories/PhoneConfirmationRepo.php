<?php

namespace App\Repositories;

use App\Models\PhoneConfirmation;

class PhoneConfirmationRepo
{
    public function store($phone, $code)
    {
        return PhoneConfirmation::create([
            'phone' => $phone,
            'code' => $code,
        ]);
    }

    public function getByPhone($phone)
    {
        return PhoneConfirmation::where('phone', $phone)->first();
    }
}