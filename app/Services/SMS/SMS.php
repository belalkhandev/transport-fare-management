<?php

namespace App\Services\SMS;

interface SMS
{
    public function send($phone, $message, $countryCode): bool;
}
