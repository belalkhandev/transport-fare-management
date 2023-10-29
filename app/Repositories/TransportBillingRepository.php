<?php

namespace App\Repositories;

use App\Enums\PaymentGateway;
use App\Models\TransportBilling;
use App\Services\UrlSortener\URLShortener;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransportBillingRepository extends Repository
{
    protected SettingRepository $settingRepository;
    protected PaymentRepository $paymentRepository;
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

        $dueConfig = json_decode($this->settingRepository->getValueByName('due_config'), true);
        $smsFormat = $this->settingRepository->getValueByName('bill_generate_send_sms_format');
        $dueDuration = $dueConfig['consider_due_in_days'] ?? 7;
        $dueDate = now()->addDays($dueDuration);
        $monthYear = Carbon::createFromDate($request->year, $request->month, 1)->format('F y');

        $bulkSms = [];


        foreach ($students as $student)
        {
            $transportBill = $this->storeTransportBillForStudent($student, $request->month, $request->year, $dueDate->format('Y-m-d'));

            $payment = $this->paymentRepository->query()
                ->where('transport_billing_id', $transportBill->id)
                ->first();

            $paymentLink = $this->generatePaymentLink($student->student_id, $transportBill->trans_id);

            if(!$payment) {
                $transId = Str::random(10);
                $this->paymentRepository->query()->create([
                    'trans_id' => $transId,
                    'transport_billing_id' => $transportBill->id,
                    'gateway' => PaymentGateway::BKASH->value,
                    'amount' => $transportBill->amount
                ]);
            } else {
                $payment->update([
                    'amount' => $transportBill->amount
                ]);
            }

            $smsMessage = str_replace([':month_year', ':due_date', ':payment_link'], [$monthYear, $dueDate, $paymentLink], $smsFormat);

            $bulkSms[] = [
                'to' => $student->contact,
                'message' => $smsMessage
            ];
        }

        //send bulk sms
    }

    private function storeTransportBillForStudent($student, $month, $year, $dueDate)
    {
        return  $this->query()->updateOrCreate(
            [
                'student_id' => $student->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'academic_plan_id' => $student->academicPlans->first()?->id,
                'due_date' => $dueDate,
                'amount' => $student->transportFee->discounted_amount ?? $student->transportFee->amount,
                'is_paid' => 0
            ]
        );
    }

    private function generatePaymentLink($studentId, $transId)
    {
        return app(URLShortener::class)->shorten(route('student.transport-bill.payment', ['studentId' => $studentId, 'transactionBillNo', $transId]), false);
    }

}
