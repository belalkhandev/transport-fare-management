<?php

namespace App\Http\Controllers\Web;

use App\Actions\StorePayment;
use App\Enums\PaymentStatus;
use App\Events\PaymentReceived;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportBillingRepository;
use App\Services\Payment\Gateway\BkashGateway;
use App\Services\Payment\PaymentCalculator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function __construct(
        protected TransportBillingRepository $transportBillingRepository,
        protected PaymentRepository $paymentRepository,
        protected StudentRepository $studentRepository
    )
    {
    }

    public function create(Request $request, BkashGateway $paymentGateway)
    {
        $transportBill = $this->getTransportBillByTransId($request->trans_id);

        $amount = $transportBill->amount + ($transportBill->due_amount ?? 0);
        $transportBillPayment = $transportBill->payment;

        if ($transportBillPayment->status == PaymentStatus::COMPLETED) {
            return redirect()->route('payment.completed', $transportBill->payment->trans_id);
        }

        $input = [
            'mode' => '0011',
            'payerReference' => '01',
            'callbackURL' => config('services.bkash_pgw.callback_url') . '/payment/callback',
            'amount' => (string) $amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $transportBillPayment->trans_id,
        ];

        $response = $paymentGateway->createPayment($input);
        $responseArr = $response->json() ?: [];

        if (isset($responseArr['paymentID'])) {
            $payment = $this->paymentRepository->query()->where('gateway_payment_id', $responseArr['paymentID'])->first();

            if ($payment) {
                abort(Response::HTTP_BAD_REQUEST, 'Duplicate Payment ID!');
            }

            $transportBillPayment->update([
                'payment_gateway' => 'bkash',
                'gateway_payment_id' => $responseArr['paymentID'],
            ]);
        }

        return Inertia::location($responseArr['bkashURL']);
    }

    public function execute(Request $request, BkashGateway $paymentGateway)
    {
        $transportBill = $this->getTransportBillByTransId($request->trans_id);

        $paymentId = $request->get('bkashPaymentId');

        if ($transportBill->payment->gateway_payment_id !== $paymentId) {
            abort(Response::HTTP_BAD_REQUEST, 'Invalid Payment ID!');
        }

        try {
            $response = $paymentGateway->executePayment($paymentId);
        } catch (Exception $exception) {
            $response = $paymentGateway->queryPayment($paymentId);
        }

        $responseArr = $response->json() ?: [];

        if (isset($responseArr['transactionStatus']) && $responseArr['transactionStatus'] === 'Completed') {
            $transportBill->payment->update([
                'status' => PaymentStatus::COMPLETED->value,
                'gateway_trans_id' => $responseArr['trxID'],
            ]);
        }

        $responseArr += ['data' => $transportBill];

        return response($responseArr, $response->status());
    }

    public function callback(Request $request, BkashGateway $paymentGateway)
    {
        $transportBill = $this->transportBillingRepository->query()
            ->select('transport_billings.*')
            ->leftJoin('payments', 'payments.transport_billing_id', '=', 'transport_billings.id')
            ->where('payments.gateway_payment_id', $request->get('paymentID'))
            ->firstOrFail();

        $status = $request->input('status');

        if ($status === 'failure') {
            return redirect()->route('payment.failed', $transportBill->payment->trans_id);
        } elseif ($status === 'cancel') {
            return redirect()->route('payment.cancel', $transportBill->payment->trans_id);
        }

        $paymentID = $request->input('paymentID');
        $response = $paymentGateway->executePayment($paymentID);
        $responseArr = json_decode($response, true);

        if (isset($responseArr['statusCode']) && $responseArr['statusCode'] !== '0000') {
            return redirect()->route('payment.failed', $transportBill->payment->trans_id)->withErrors(['bkash_failed_message' => $responseArr['statusMessage'] ?? null]);
        }

        $transportBill->payment->update([
            'status' => PaymentStatus::COMPLETED->value,
            'gateway_trans_id' => $responseArr['trxID'] ?? null,
        ]);

        if (isset($responseArr['message'])) {
            sleep(1);
            $paymentGateway->queryPayment($paymentID);

            return redirect()->route('payment.success',  $transportBill->payment->trans_id);
        }

        return redirect()->route('payment.success',  $transportBill->payment->trans_id);
    }

    public function paymentSuccess($transId)
    {
        $transportBill = $this->getTransportBillByTransId($transId);
        $student = $this->getStudentById($transportBill->student_id);

        return Inertia::render('TransportPayment/Success', [
            'transport_bill' => $transportBill,
            'student' => $student
        ]);
    }

    public function paymentCompleted($transId)
    {
        $transportBill = $this->getTransportBillByTransId($transId);
        $student = $this->getStudentById($transportBill->student_id);

        return Inertia::render('TransportPayment/Completed', [
            'transport_bill' => $transportBill,
            'student' => $student
        ]);
    }

    public function paymentCanceled($transId)
    {
        $transportBill = $this->getTransportBillByTransId($transId);
        $student = $this->getStudentById($transportBill->student_id);

        return Inertia::render('TransportPayment/Canceled', [
            'transport_bill' => $transportBill,
            'student' => $student
        ]);
    }

    public function paymentFailed($transId)
    {
        $transportBill = $this->getTransportBillByTransId($transId);
        $student = $this->getStudentById($transportBill->student_id);

        return Inertia::render('TransportPayment/Failed', [
            'transport_bill' => $transportBill,
            'student' => $student
        ]);
    }

    private function getTransportBillByTransId($transId)
    {
        return $this->transportBillingRepository->getByTransId($transId);
    }

    private function getStudentById($studentId)
    {
        return $this->studentRepository->query()
            ->with([
                'academicPlans' => function($query) {
                    return $query->with('academicYear', 'academicClass', 'academicGroup', 'academicSection')->latest();
                }
            ])
            ->findOrFail($studentId);
    }
}