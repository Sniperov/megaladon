<?php

namespace App\Repositories;

use App\Models\Invoice;

class InvoiceRepo
{
    public function update(int $id, array $data)
    {
        Invoice::where('id', $id)
            ->update($data);
    }
}