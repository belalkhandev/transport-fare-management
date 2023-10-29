<?php

namespace App\Services\SMS;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SslSms implements SMS
{
    private $api_token;

    private $endpoint;

    public function __construct()
    {
        $this->api_token = config('services.ssl_sms_v3.api_token');
        $this->endpoint = config('services.ssl_sms_v3.endpoint');
    }

    public function send($phone, $message, $countryCode = '88', $purpose = null): bool
    {
        if ($countryCode && $countryCode != '88') {
            $purpose = 'not_bd';
            $phone = $countryCode . $phone;
        } else {
            $phone = mb_substr($phone, mb_strpos($phone, '01'));
            $phone = '88' . $phone;
        }

        switch ($purpose) {
            case 'otp':
                $sid = config('services.ssl_sms_v3.sid_otp');
                break;
            case 'bulk':
                $sid = config('services.ssl_sms_v3.sid_bulk');
                break;
            case 'not_bd':
                $sid = config('services.ssl_sms_v3.sid_international');
                break;
            default:
                $sid = config('services.ssl_sms_v3.sid');
        }

        try {
            return $this->sendSms($phone, $message, $sid);
        } catch (Exception $exception) {
            Log::error('[' . __METHOD__ . "] Error occurred while sending message to {$phone}, Error: {$exception->getMessage()}");
        }

        return false;
    }

    private function sendSms($phone, $message, $sid): bool
    {
        $response = Http::post($this->endpoint, [
            'api_token' => $this->api_token,
            'csms_id' => uniqid(),
            'msisdn' => $phone,
            'sms' => $message,
            'sid' => $sid,
        ]);

        $responseArr = $response->json() ?: [];
        $responseStr = json_encode($responseArr, JSON_PRETTY_PRINT);

        if (isset($responseArr['status']) && $responseArr['status'] === 'SUCCESS') {
            info('[' . __METHOD__ . "] SMS sent to: $phone, Message: {$message}, SID: {$sid}, Response: {$responseStr}");

            return true;
        }

        Log::error('[' . __METHOD__ . "] SMS sending failed, Response: {$responseStr}");

        return false;
    }
}
