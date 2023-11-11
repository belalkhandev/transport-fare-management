<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundRepository extends Repository
{
    public function model()
    {
        return Refund::class;
    }

    public function createRefundByPayment(Payment $payment, $note = null)
    {
        return $this->query()->create([
            'payment_id' => $payment->id,
            'gateway_payment_id' => $payment->gateway_payment_id,
            'status' => 'processing',
            'note' => $note ?? 'Bill canceled'
        ]);
    }

}
