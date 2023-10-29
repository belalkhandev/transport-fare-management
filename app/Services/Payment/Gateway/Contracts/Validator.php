<?php

namespace App\Services\Payment\Gateway\Contracts;

use App\Models\Payment;

interface Validator
{
    public function isPaymentValid(Payment $payment): bool;
}
