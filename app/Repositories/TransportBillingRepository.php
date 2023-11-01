<?php

namespace App\Repositories;

use App\Enums\PaymentGateway;
use App\Models\TransportBilling;
use App\Services\SMS\SMS;
use App\Services\UrlSortener\URLShortener;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransportBillingRepository extends Repository
{
    protected SettingRepository $settingRepository;
    protected PaymentRepository $paymentRepository;
    protected SmsLogRepository $smsLogRepository;

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

    public function generateMonthlyBill($request, $students)
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

        foreach ($students as $student)
        {
            $transportBill = $this->storeTransportBillForStudent($student, $request->month, $request->year, $dueDate);

            if ($request->send_sms) {
                $paymentLink = $this->generatePaymentLink($student->student_id, $transportBill->trans_id);
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

    private function generatePaymentLink($studentId, $transId)
    {
        return app(URLShortener::class)->shorten(route('student.transport-bill.payment', ['studentId' => $studentId, 'transactionBillNo', $transId]), false);
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

}
