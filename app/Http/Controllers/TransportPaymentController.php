<?php

namespace App\Http\Controllers;

use App\Repositories\PaymentRepository;
use App\Repositories\SettingRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportBillingRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportPaymentController extends Controller
{
    public function __construct(
        protected TransportBillingRepository $transportBillingRepository,
        protected PaymentRepository $paymentRepository,
        protected StudentRepository $studentRepository,
        protected SettingRepository $settingRepository
    )
    {
    }


    public function index($transId)
    {
        $transportBill = $this->transportBillingRepository->query()
            ->leftJoin('payments', 'payments.transport_billing_id', '=', 'transport_billings.id')
            ->where('payments.trans_id', $transId)
            ->firstOrFail();

        return redirect(route('transport-payment.student', $transportBill->student->student_id));
    }

    public function alternative($studentId, $transId)
    {
        return redirect(route('transport-payment.student', $studentId));
    }

    public function studentPayments($studentId)
    {
        $student = $this->studentRepository->getByStudentId($studentId);
        $transportBills = $this->transportBillingRepository->getByStudentId($student->id);
        $unpaidBill = $this->transportBillingRepository->getUnpaidBillByStudentId($student->id);

        $totalBillAmount = $transportBills->sum(function ($bill) {
            return $bill->payment->amount;
        });

        $totalPaidAmount = $transportBills->where('is_paid', 1)->sum(function ($bill) {
           return $bill->payment->amount;
        });

        $dueConfig = json_decode($this->settingRepository->getValueByName('due_config'), true);

        return Inertia::render('Payment/Index', [
            'student' => $student,
            'transportBills' => $transportBills,
            'total_bill_amount' => number_format($totalBillAmount, 2),
            'total_paid_amount' => number_format($totalPaidAmount, 2),
            'total_due_amount' => number_format(($totalBillAmount - $totalPaidAmount) ?? 0, 2),
            'unpaid_bill' => $unpaidBill,
            'penalty_on_due' => $dueConfig['fine_after_due_date'] ?? 100
        ]);
    }
}
