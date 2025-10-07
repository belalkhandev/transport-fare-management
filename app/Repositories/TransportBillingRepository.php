<?php

namespace App\Repositories;

use App\Enums\PaymentGateway;
use App\Models\TransportBilling;
use App\Services\SMS\SMS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TransportBillingRepository extends Repository
{
    protected SettingRepository $settingRepository;

    protected PaymentRepository $paymentRepository;

    protected SmsLogRepository $smsLogRepository;

    protected StudentRepository $studentRepository;

    protected SMS $sms;

    /**
     * {@inheritDoc}
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
        $discount = $this->settingRepository->getValueByName('billing_monthly_discount');

        foreach ($students as $student) {
            $transportBill = $this->storeTransportBillForStudent($student, $request->month, $request->year, $dueDate, $discount);
            
            if (!$transportBill) {
                continue;
            }

            $phone = $this->formatContactNumber($student->contact_no);

            if ($request->send_sms && $phone && $smsFormat) {
                $paymentLink = $this->generatePaymentLink($student->student_id);
                $smsMessage = str_replace([':amount', ':month_year', ':due_date', ':payment_link'], [$transportBill->amount, $monthYear, $dueDate, $paymentLink], $smsFormat);

                $bulkSms[] = [
                    'to' => $phone,
                    'message' => $smsMessage,
                ];

                $this->smsLogRepository->storeByRequest($student->contact_no, $smsMessage);
            }
        }

        if ($request->send_sms) {
            $this->sms->sendBulk(json_encode($bulkSms));
        }
    }

    private function formatContactNumber(string $number): ?string
    {
        $digits = preg_replace('/\D/', '', $number);

        if (str_starts_with($digits, '880')) $formatted = $digits;
        elseif (str_starts_with($digits, '01')) $formatted = '88' . $digits;
        elseif (str_starts_with($digits, '8801')) $formatted = $digits;
        else return null;

        return strlen($formatted) === 13 ? $formatted : null;
    }



    private function getApplicableStudents($month, $year)
    {
        $this->studentRepository = app(StudentRepository::class);

        $excludeStudentIds = $this->query()
            ->where('month', $month)
            ->where('year', $year)
            ->where('is_paid', 1)
            ->get()
            ->pluck('student_id')
            ->toArray();

        return $this->studentRepository->getActiveStudents($excludeStudentIds);
    }

    private function storeTransportBillForStudent($student, $month, $year, $dueDate, $discount)
    {
        
        $originalAmount = $student->transportFee->discounted_amount ?? $student->transportFee?->fee?->amount;
        
        if (!$originalAmount) {
            return null;
        }
        
        $payableAmount = $this->calculateDiscountedAmount($originalAmount, $discount, $month, $year, $student->education_level);

        $transportBill = $this->query()->updateOrCreate(
            [
                'student_id' => $student->id,
                'month' => $month,
                'year' => $year,
            ],
            [
                'academic_plan_id' => $student->academicPlans->first()?->id,
                'due_date' => $dueDate,
                'amount' => $payableAmount,
                'is_paid' => 0,
            ]
        );

        $this->paymentRepository->query()->updateOrCreate(
            [
                'transport_billing_id' => $transportBill->id,
                'gateway' => PaymentGateway::BKASH->value,
            ],
            [
                'trans_id' => Str::random(10),
                'amount' => $transportBill->amount,
            ]
        );

        return $transportBill;
    }

    private function generatePaymentLink($studentId): string
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
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        $currentDate = now()->format('Y-m-d');

        $bills->map(function ($bill) use ($currentDate, $dueConfig) {
            if (! $bill->is_paid && $currentDate > $bill->due_date) {
                $bill->update([
                    'due_amount' => $dueConfig['fine_after_due_date'],
                ]);

                $bill->payment->update([
                    'amount' => $bill->amount + $dueConfig['fine_after_due_date'],
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
                    'due_amount' => $dueConfig['fine_after_due_date'],
                ]);

                $bill->payment->update([
                    'amount' => $bill->amount + $dueConfig['fine_after_due_date'],
                ]);
            }
        });

        return $bills;
    }

    private function calculateDiscountedAmount($amount, $discount, $month, $year, $educationLevel = null): float
    {
        if (! $discount) {
            return $amount;
        }

        $discountArr = json_decode($discount, true);

        $discountPercentage = $discountArr['discount_percentage'][$educationLevel] ?? 0;
        $discountInAmount = $discountArr['discount_amount'][$educationLevel] ?? 0;
        $discountYear = $discountArr['year'] ?? null;
        $discountMonth = $discountArr['month'] ?? null;

        if (! ($discountYear == $year && $discountMonth == $month)) {
            return $amount;
        }

        if ($discountInAmount && $discountInAmount != 0) {
            return round($amount - $discountInAmount);
        }

        $discountAmount = $amount * ($discountPercentage / 100);

        return max(round($amount - $discountAmount), 0);
    }
}
