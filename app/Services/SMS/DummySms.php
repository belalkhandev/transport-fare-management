<?php

namespace App\Services\SMS;

class DummySms implements SMS
{
    public function send($phone, $message, $countryCode = '88'): bool
    {
        info('[' . __METHOD__ . '] SMS is in dummy mode, mobile_number: ' . $phone . ', sms: ' . $message);

        return true;
    }
}
