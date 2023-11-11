<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Repositories\PaymentRepository;
use App\Repositories\RefundRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportBillingRepository;
use App\Services\Payment\Gateway\BkashGateway;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RefundController extends Controller
{
    public function __construct(
        protected PaymentRepository $paymentRepository,
        protected RefundRepository $refundRepository,
        protected TransportBillingRepository $transportBillRepository,
        protected StudentRepository $studentRepository
    )
    {
    }

    public function getRefund($transId)
    {
        $transportBill = $this->transportBillRepository->getByTransId($transId);
        $student = $this->studentRepository->getById($transportBill->student_id);

        if ($transportBill->payment->status !== PaymentStatus::COMPLETED->value) {
            abort(406, 'Payment has not completed yet');
        }

        return Inertia::render('TransportBill/RefundPayment', [
            'transport_bill' => $transportBill,
            'student' => $student
        ]);
    }

    public function refund(Request $request, BkashGateway $paymentGateway, $transId)
    {
        $payment = $this->paymentRepository->query()
            ->where('trans_id', $transId)
            ->firstOrFail();

        if ($payment->status !== PaymentStatus::COMPLETED->value) {
            abort(406, "Not acceptable");
        }

        $refund = $this->refundRepository->createRefundByPayment($payment, $request->note);
        $response = $paymentGateway->initiateRefundProcess($payment, $refund);

        $refund->update([
            'refund_trans_id' => $response['trx_id'],
            'refunded_to' => $response['refunded_to'] ?? '',
            'amount' => $response['amount'],
            'charge' => $response['charge'],
            'process_initiated_at' => $response['process_initiated_at'],
            'status' => $response['status']
        ]);

        $payment->update([
            'status' => PaymentStatus::REFUNDED->value
        ]);

        return to_route('transport-bill.index');
    }
}
