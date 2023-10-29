<?php

namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Payment::class;
    }

}
