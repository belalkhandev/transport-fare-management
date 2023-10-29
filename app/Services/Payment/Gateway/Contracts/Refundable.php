<?php

namespace App\Services\Payment\Gateway\Contracts;

use App\Models\Payment;
use App\Models\Refund;

interface Refundable
{
    public function initiateRefundProcess(Payment $payment, Refund $refund): ?array;

    public function checkRefundStatus(Refund $refund): ?array;
}
