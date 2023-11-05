<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Repositories\PaymentRepository;
use App\Repositories\SettingRepository;
use App\Repositories\SmsLogRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportBillingRepository;
use App\Services\SMS\SMS;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportBillingController extends Controller
{
    public function __construct(
        protected TransportBillingRepository $transportBillRepository,
        protected PaymentRepository $paymentRepository,
        protected StudentRepository $studentRepository,
        protected SettingRepository $settingRepository
    )
    {
    }

    public function index(Request $request)
    {
        $bills = $this->transportBillRepository->query()
            ->select('transport_billings.*')
            ->with([
                'student',
                'payment.refund'
            ])
            ->leftJoin('students', 'students.id', '=', 'transport_billings.student_id')
            ->leftJoin('payments', 'transport_billings.id', '=', 'payments.transport_billing_id')
            ->when($search = $request->search, function ($query) use ($search) {
                $query->where('students.student_id', 'LIKE', '%'.$search.'%')
                    ->orWhere('students.contact_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('payments.trans_id', 'LIKE', '%'.$search.'%');
            })
            ->when($month = $request->month, function ($query) use ($month) {
                $query->where('transport_billings.month', $month);
            })
            ->when($year = $request->year, function ($query) use ($year) {
                $query->where('transport_billings.year', $year);
            })
            ->latest('transport_billings.created_at')
            ->paginate();

        $bills->map(function($bill) {
           $bill->amount = number_format($bill->amount + $bill->due_amount, 2);
        });

        $monthYear = $this->preparedMonthYear();

        return Inertia::render('TransportBill/Index', [
            'bills' => $bills,
            'months' => $monthYear['months'],
            'years' => $monthYear['years'],
            'filterData' => $request->all()
        ]);
    }

    public function paymentList()
    {
        $payments = $this->paymentRepository->query()
            ->with([
                'transportBill.student'
            ])
            ->where('status', PaymentStatus::COMPLETED->value)
            ->orderByDesc('transaction_date')
            ->paginate();

        return Inertia::render('TransportBill/Payments', [
            'payments' => $payments
        ]);
    }

    public function generateBills()
    {
        $monthYear = $this->preparedMonthYear();

        return Inertia::render('TransportBill/GenerateBill', [
            'months' => $monthYear['months'],
            'years' => $monthYear['years']
        ]);
    }

    public function storeGeneratedBills(Request $request)
    {
        $request->validate([
            'month' => ['required'],
            'year' => 'required'
        ]);

        try {
            $students = $this->studentRepository->getActiveStudents();
            $this->transportBillRepository->generateMonthlyBill($request, $students);
        }catch (Exception $e) {
            return $this->json($e->getMessage(), null, 400);
        }
    }

    private function preparedMonthYear(): array
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $timestamp = mktime(0, 0, 0, $i, 1);
            $months[] = [
                'value' => date('n', $timestamp),
                'name' => date('F', $timestamp)
            ];
        }

        $currentYear =  date('Y');
        $lastYear = $currentYear - 1;
        $nextYear = $currentYear + 1;

        $years[] = [
            'value' => $lastYear,
            'name' => $lastYear
        ];

        $years[] = [
            'value' => $currentYear,
            'name' => $currentYear
        ];

        $years[] = [
            'value' => $nextYear,
            'name' => $nextYear
        ];

        return [
            'months' => $months,
            'years' => $years
        ];
    }

    public function paymentReceiveManually($transId)
    {
        $transportBill = $this->transportBillRepository->getByTransId($transId);
        $student = $this->studentRepository->getById($transportBill->student_id);

        return Inertia::render('TransportBill/PaymentReceiveManually', [
            'transport_bill' => $transportBill,
            'student' => $student
        ]);
    }

    public function storeManualPayment(Request $request, $transId, SMS $sms)
    {
        $smsLogRepo = app(SmsLogRepository::class);

        $request->validate([
            'payment_trans_id' => 'required',
            'gateway' => 'required',
        ]);

        $transportBill = $this->transportBillRepository->getByTransId($transId);

        $transportBill->payment->update([
            'gateway_trans_id' => $request->payment_trans_id,
            'gateway' => $request->gateway,
            'transaction_date' => $request->transaction_date ? Carbon::parse($request->transaction_date)->format('Y-m-d') : now()->format('Y-m-d'),
            'status' => PaymentStatus::COMPLETED->value
        ]);

        $transportBill->update([
            'is_paid' => 1
        ]);

        if ($request->send_sms) {
            $smsFormat = $this->settingRepository->getValueByName('payment_confirmation_sms');
            $smsMessage = str_replace([':amount', ':month_year', ':student_id'], [$transportBill->payment->amount, $transportBill->formatted_month_year, $transportBill->student->student_id], $smsFormat);

            $phone = mb_substr($transportBill->student->contact_no, mb_strpos($transportBill->student->contact_no, '01'));
            $phone = '88' . $phone;

            $sms->send($phone, $smsMessage);
            $smsLogRepo->storeByRequest($phone, $smsMessage);
        }

        return to_route('payment.index');
    }
}
