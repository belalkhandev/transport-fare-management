<?php

namespace App\Services\SMS;

interface SMS
{
    public function send($phone, $message): bool;

    public function sendBulk($messages):bool;
}
