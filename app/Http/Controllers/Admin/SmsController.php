<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\SmsLogRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportBillingRepository;
use App\Services\SMS\SMS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SmsController extends Controller
{
    public function __construct(
        protected SmsLogRepository $smsLogRepository,
        protected StudentRepository $studentRepository,
        protected SettingRepository $settingRepository,
        protected TransportBillingRepository $transportBillingRepository,
    )
    {
    }

    public function sendSms()
    {
        return Inertia::render('SMS/Send');
    }

    public function send(Request $request, SMS $sms)
    {
        $request->validate([
            'phone'  => ['required','regex:/(01)[0-9]{9}/'],
            'message' => ['required']
        ]);

        $phone = mb_substr($request->phone, mb_strpos($request->phone, '01'));
        $phone = '88' . $phone;
        $message = $request->message;

        $sms->send($phone, $message);

        $this->smsLogRepository->storeByRequest($phone, $message);

        return to_route('sms.send-sms');
    }

    public function groupSms()
    {
        return Inertia::render('SMS/SendGroup');
    }

    public function groupSmsSend(Request $request, SMS $sms)
    {
        $request->validate([
            'message' => ['required']
        ]);

        if ($request->receiver == 'all') {
            $students = $this->studentRepository->query()->select('id', 'student_id', 'contact_no')->get();
        }

        if ($request->receiver == 'only_active') {
            $students = $this->studentRepository->query()->select('id', 'student_id', 'contact_no')->active()->get();
        }

        $bulkSms = [];
        foreach ($students as $student)
        {
            $phone = mb_substr($student->contact_no, mb_strpos($student->contact_no, '01'));
            $phone = '88' . $phone;

            $bulkSms[] = [
                'to' => $phone,
                'message' => $request->message
            ];

            $this->smsLogRepository->storeByRequest($phone, $request->message);
        }

        $sms->sendBulk(json_encode($bulkSms));
    }

    public function dueAlert()
    {
        $monthYear = $this->preparedMonthYear();
        $smsFormat = $this->settingRepository->getValueByName('due_alert_sms_format');

        return Inertia::render('SMS/SendDueAlert', [
            'months' => $monthYear['months'],
            'years' => $monthYear['years'],
            'sms_format' => $smsFormat
        ]);
    }

    public function dueAlertSend(Request $request, SMS $sms)
    {
        $request->validate([
            'month' => ['required'],
            'year' => ['required'],
            'sms_format' => ['required']
        ]);

        $dueBills = $this->transportBillingRepository->getDueBillsByMonthYear($request->month, $request->year);

        $bulkSms = [];
        foreach ($dueBills as $bill)
        {
            $phone = mb_substr($bill->student->contact_no, mb_strpos($bill->student->contact_no, '01'));
            $phone = '88' . $phone;
            $monthYear = Carbon::createFromDate($request->year, $request->month, 1)->format('F y');
            $paymentLink = route('transport-payment.student', $bill->student->student_id);
            $smsMessage = str_replace([':amount', ':month_year', ':payment_link'], [$bill->payment->amount, $monthYear, $paymentLink], $request->sms_format);

            $bulkSms[] = [
                'to' => $phone,
                'message' => $smsMessage
            ];

            $this->smsLogRepository->storeByRequest($phone, $smsMessage);
        }

        $sms->sendBulk(json_encode($bulkSms));

        return to_route('sms.due-alert');
    }

    public function smsLogs()
    {
        $logs = $this->smsLogRepository->getLatestByPaginate();

        return Inertia::render('SMS/Logs', [
            'logs' => $logs
        ]);
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
}
