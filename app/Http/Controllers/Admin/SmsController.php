<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SmsLogRepository;
use App\Repositories\StudentRepository;
use App\Services\SMS\SMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SmsController extends Controller
{
    public function __construct(
        protected SmsLogRepository $smsLogRepository,
        protected StudentRepository $studentRepository
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

    public function smsLogs()
    {
        $logs = $this->smsLogRepository->getLatestByPaginate();

        return Inertia::render('SMS/Logs', [
            'logs' => $logs
        ]);
    }
}
