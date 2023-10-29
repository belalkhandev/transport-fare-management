<?php

namespace App\Http\Controllers\API;

use App\Actions\StorePayment;
use App\Events\PaymentReceived;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payment\Gateway\BkashGateway;
use App\Services\Payment\PaymentCalculator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function createBkash(
        Request $request,
        $order_ref,
        BkashGateway $paymentGateway,
        PaymentCalculator $paymentCalculator,
    ) {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'intent' => ['required', 'in:sale,authorization'],
            'callback_url' => ['nullable', 'url'],
        ]);

        $order = Order::ofRef($order_ref)->firstOrFail();

        if ($order->is_paid) {
            abort(Response::HTTP_BAD_REQUEST, 'Already paid for this order!');
        }

        $paymentCalculator->validateAmount($order, $request->amount);

        $input = [
            'amount' => (string) $request->amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $order->payment->trx_id,
            'mode' => '0011',
            'payerReference' => '01',
            'callbackURL' => $request->callback_urll ?? config('services.bkash_pgw.callback_url'),
        ];

        $response = $paymentGateway->createPayment($input);
        $responseArr = $response->json() ?: [];

        if (isset($responseArr['paymentID'])) {
            $payment = Payment::where('gateway_payment_id', $responseArr['paymentID'])->first();

            if ($payment) {
                abort(Response::HTTP_BAD_REQUEST, 'Duplicate Payment ID!');
            }

            $order->payment->update([
                'gateway' => 'bkash_pgw',
                'gateway_payment_id' => $responseArr['paymentID'],
            ]);
        }

        return response($responseArr, $response->status());
    }

    public function executeBkash(
        Request $request,
        PaymentCalculator $paymentCalculator,
        StorePayment $storePayment,
        BkashGateway $paymentGateway,
        $order_ref,
        $paymentId
    ) {
        $order = Order::ofRef($order_ref)->firstOrFail();

        if ($order->payment->gateway_payment_id !== $paymentId) {
            abort(Response::HTTP_BAD_REQUEST, 'Invalid Payment ID!');
        }

        try {
            $response = $paymentGateway->executePayment($paymentId);
        } catch (Exception $exception) {
            $response = $paymentGateway->queryPayment($paymentId);
        }

        $responseArr = $response->json() ?: [];

        if (isset($responseArr['transactionStatus']) && $responseArr['transactionStatus'] === 'Completed') {
            $input = $paymentGateway->getInputFields($responseArr);

            $payment = $storePayment->store($order, $order->payment, $paymentCalculator, $paymentGateway, $input);

            if ($payment['status'] === 'success') {
                event(new PaymentReceived($order, $payment));
            }
        }

        $responseArr += ['data' => new OrderPayemnt($order)];

        return response($responseArr, $response->status());
    }
}
