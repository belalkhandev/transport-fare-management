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

    public function createRefundByPayment(Payment $payment)
    {
        return $this->query()->create([
            'payment_id' => $payment->id,
            'gateway_payment_id' => $payment->gateway_payment_id,
            'status' => 'processing',
            'note' => 'Bill canceled'
        ]);
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }

    public function updateByRequest(Request $request, $refundId)
    {
        return $this->query()->findOrFail($refundId)?->update([

        ]);
    }

    public function deleteByRequest($refundId)
    {
        return $this->query()->findOrFail($refundId)?->delete();
    }

}
