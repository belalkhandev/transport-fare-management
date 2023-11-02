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
            ->select('transport_billings.*')
            ->with([
                'payment'
            ])
            ->leftJoin('payments', 'payments.transport_billing_id', '=', 'transport_billings.id')
            ->where('payments.trans_id', $transId)
            ->orWhere
            ->firstOrFail();

        $student = $this->studentRepository->query()
            ->with([
                'academicPlans' => function($query) {
                    return $query->with('academicYear', 'academicClass', 'academicGroup', 'academicSection')->latest();
                }
            ])
            ->findOrFail($transportBill->student_id);

        $dueConfig = json_decode($this->settingRepository->getValueByName('due_config'), true);

        $currentDate = now()->format('Y-m-d');

        if ($currentDate > $transportBill) {
            $transportBill->update([
                'due_amount' => $dueConfig['fine_after_due_date']
            ]);

            $transportBill->payment->update([
                'amount' => $transportBill->amount + $dueConfig['fine_after_due_date']
            ]);
        }


        return Inertia::render('TransportPayment/Index', [
            'transport_bill' => $transportBill,
            'student' => $student,
            'due_amount' => $dueConfig['fine_after_due_date'] ?? 100
        ]);
    }

    public function alternative($studentId, $transId)
    {
        $transportBill = $this->transportBillingRepository->query()
            ->select('transport_billings.*')
            ->with([
                'payment'
            ])
            ->leftJoin('students', 'students.id', '=', 'transport_billings.student_id')
            ->where('students.student_id', $studentId)
            ->firstOrFail();


        $student = $this->studentRepository->query()
            ->with([
                'academicPlans' => function($query) {
                    return $query->with('academicYear', 'academicClass', 'academicGroup', 'academicSection')->latest();
                }
            ])
            ->findOrFail($transportBill->student_id);

        $dueConfig = json_decode($this->settingRepository->getValueByName('due_config'), true);

        $currentDate = now()->format('Y-m-d');

        if ($currentDate > $transportBill) {
            $transportBill->update([
                'due_amount' => $dueConfig['fine_after_due_date']
            ]);

            $transportBill->payment->update([
                'amount' => $transportBill->amount + $dueConfig['fine_after_due_date']
            ]);
        }


        return Inertia::render('TransportPayment/Index', [
            'transport_bill' => $transportBill,
            'student' => $student,
            'due_amount' => $dueConfig['fine_after_due_date'] ?? 100
        ]);
    }
}
