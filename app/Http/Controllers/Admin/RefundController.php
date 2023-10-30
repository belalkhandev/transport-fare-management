<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\PaymentRepository;
use App\Repositories\RefundRepository;
use App\Services\Payment\Gateway\BkashGateway;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function __construct(
        protected PaymentRepository $paymentRepository,
        protected RefundRepository $refundRepository
    )
    {
    }

    public function refund(Request $request, BkashGateway $paymentGateway)
    {
        $payment = $this->paymentRepository->query()->where('trans_id', $request->trans_id)->firstOrFail();
        $refund = $this->refundRepository->createRefundByPayment($payment);
        $response = $paymentGateway->initiateRefundProcess($payment, $refund);

        $refund->update([
            'refund_trans_id' => $response['trx_id'],
            'refunded_to' => $response['refunded_to'] ?? '',
            'amount' => $response['amount'],
            'charge' => $response['charge'],
            'process_initiated_at' => $response['process_initiated_at'],
        ]);

        return to_route('transport-bill.index');
    }
}
