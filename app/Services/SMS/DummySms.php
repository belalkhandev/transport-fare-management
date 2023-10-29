<?php

namespace App\Services\SMS;

class DummySms implements SMS
{
    public function send($phone, $message): bool
    {
        info('[' . __METHOD__ . '] SMS is in dummy mode, mobile_number: ' . $phone . ', sms: ' . $message);

        return true;
    }

    public function sendBulk($messages): bool
    {
        info('[' . __METHOD__ . '] Bulk SMS send');

        return true;
    }
}
