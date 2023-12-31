<?php

namespace App\Repositories;

use App\Enums\PaymentGateway;
use App\Models\TransportBilling;
use App\Services\SMS\SMS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransportBillingRepository extends Repository
{
    protected SettingRepository $settingRepository;
    protected PaymentRepository $paymentRepository;
    protected SmsLogRepository $smsLogRepository;

    protected StudentRepository $studentRepository;

    protected SMS $sms;
    /**
     * @inheritDoc
     */
    public function model()
    {
        return TransportBilling::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }

    public function updateByRequest(Request $request, $transportBillingId)
    {
        return $this->query()->findOrFail($transportBillingId)->update([

            ]);
    }

    public function deleteByRequest($transportBillingId)
    {
        return $this->query()->findOrFail($transportBillingId)->delete();
    }

    public function generateMonthlyBill($request)
    {
        $this->settingRepository = app(SettingRepository::class);
        $this->paymentRepository = app(PaymentRepository::class);
        $this->smsLogRepository = app(SmsLogRepository::class);
        $this->sms = app(SMS::class);

        $dueConfig = json_decode($this->settingRepository->getValueByName('due_config'), true);
        $smsFormat = $this->settingRepository->getValueByName('bill_generate_send_sms_format');
        $dueDuration = $dueConfig['consider_due_in_days'] ?? 7;
        $dueDate = now()->addDays($dueDuration)->format('Y-m-d');
        $monthYear = Carbon::createFromDate($request->year, $request->month, 1)->format('F y');

        $bulkSms = [];

        $students = $this->getApplicableStudents($request->month, $request->year);

        foreach ($students as $student)
        {

            $transportBill = $this->storeTransportBillForStudent($student, $request->month, $request->year, $dueDate);

            if ($request->send_sms) {
                $paymentLink = $this->generatePaymentLink($student->student_id);
                $smsMessage = str_replace([':amount', ':month_year', ':due_date', ':payment_link'], [$transportBill->amount, $monthYear, $dueDate, $paymentLink], $smsFormat);

                $phone = mb_substr($student->contact_no, mb_strpos($student->contact_no, '01'));
                $phone = '88' . $phone;

                $bulkSms[] = [
                    'to' => $phone,
                    'message' => $smsMessage
                ];

                $this->smsLogRepository->storeByRequest($student->contact_no, $smsMessage);
            }
        }

        if($request->send_sms)
            $this->sms->sendBulk(json_encode($bulkSms));
    }

    private function getApplicableStudents($month, $year)
    {
        $this->studentRepository = app(StudentRepository::class);

        $studentsIds = $this->query()
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->pluck('student_id')
            ->toArray();

        return $this->studentRepository->getActiveStudents($studentsIds);
    }

    private function storeTransportBillForStudent($student, $month, $year, $dueDate)
    {
        $transportBill = $this->query()->updateOrCreate(
            [
                'student_id' => $student->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'academic_plan_id' => $student->academicPlans->first()?->id,
                'due_date' => $dueDate,
                'amount' => $student->transportFee->discounted_amount ?? $student->transportFee->fee->amount,
                'is_paid' => 0
            ]
        );

        $this->paymentRepository->query()->updateOrCreate(
            [
                'transport_billing_id' => $transportBill->id,
                'gateway' => PaymentGateway::BKASH->value
            ],
            [
                'trans_id' => Str::random(10),
                'amount' => $transportBill->amount
            ]
        );

        return $transportBill;
    }

    private function generatePaymentLink($studentId):string
    {
        return route('transport-payment.student', $studentId);
    }

    public function getByTransId($transId)
    {
        return $this->query()
            ->select('transport_billings.*')
            ->with(['payment'])
            ->leftJoin('payments', 'payments.transport_billing_id', '=', 'transport_billings.id')
            ->where('payments.trans_id', $transId)
            ->firstOrFail();
    }

    public function getByStudentId($studentId)
    {
        $settingsRepo = app(SettingRepository::class);
        $dueConfig = json_decode($settingsRepo->getValueByName('due_config'), true);

        $bills = $this->query()
            ->with('payment')
            ->where('student_id', $studentId)
            ->latest('month')
            ->get();

        $currentDate = now()->format('Y-m-d');

        $bills->map(function ($bill) use ($currentDate, $dueConfig) {
            if (!$bill->is_paid && $currentDate > $bill->due_date) {
                $bill->update([
                    'due_amount' => $dueConfig['fine_after_due_date']
                ]);

                $bill->payment->update([
                    'amount' => $bill->amount + $dueConfig['fine_after_due_date']
                ]);
            }
        });

        return $bills;
    }
    public function getUnpaidBillByStudentId($studentId)
    {
        return $this->query()
            ->with('payment')
            ->where('student_id', $studentId)
            ->where('is_paid', 0)
            ->first();
    }

    public function getDueBillsByMonthYear($month, $year)
    {
        $settingsRepo = app(SettingRepository::class);
        $dueConfig = json_decode($settingsRepo->getValueByName('due_config'), true);

        $bills = $this->query()
            ->with('payment', 'student')
            ->where('is_paid', 0)
            ->where('month', $month)
            ->where('year', $year)
            ->get();

        $currentDate = now()->format('Y-m-d');

        $bills->map(function ($bill) use ($currentDate, $dueConfig) {
            if ($currentDate > $bill->due_date) {
                $bill->update([
                    'due_amount' => $dueConfig['fine_after_due_date']
                ]);

                $bill->payment->update([
                    'amount' => $bill->amount + $dueConfig['fine_after_due_date']
                ]);
            }
        });

        return $bills;
    }

}
