<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends Repository
{
    /**
     * {@inheritDoc}
     */
    public function model()
    {
        return Payment::class;
    }
}
