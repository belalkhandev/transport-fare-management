<?php

namespace App\Services\SMS;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BulkSMSBD implements SMS
{
    private $api_key;
    private $sender_id;
    private $endpoint;

    public function __construct()
    {
        $this->endpoint = config('services.sms.api_url');
        $this->api_key = config('services.sms.api_key');
        $this->sender_id = config('services.sms.sender_id');
    }

    public function send($phone, $message): bool
    {
        try {
            return $this->sendSms($phone, $message);
        } catch (Exception $exception) {
            Log::error('[' . __METHOD__ . "] Error occurred while sending message to {$phone}, Error: {$exception->getMessage()}");
        }

        return false;
    }

    public function sendBulk($messages): bool
    {
        try {
            return $this->sendBulkSms($messages);
        } catch (Exception $exception) {
            Log::error('[' . __METHOD__ . "] Error occurred while sending bulk sms, Error: {$exception->getMessage()}");
        }
    }

    private function sendSms($phone, $message): bool
    {
        $endpoint = "{$this->endpoint}/smsapi";

        $response = Http::post($endpoint, [
            'api_key' => $this->api_key,
            'senderid' => $this->sender_id,
            'number' => $phone,
            'message' => $message
        ]);

        $responseArr = $response->json() ?: [];
        $responseStr = json_encode($responseArr, JSON_PRETTY_PRINT);

        if (isset($responseArr['status']) && $responseArr['status'] === 'SUCCESS') {
            info('[' . __METHOD__ . "] SMS sent to: $phone, Message: {$message}, Response: {$responseStr}");
            return true;
        }

        Log::error('[' . __METHOD__ . "] SMS sending failed, Response: {$responseStr}");

        return false;
    }

    private function sendBulkSms($messages)
    {
        $endpoint = "{$this->endpoint}/smsapimany";

        $response = Http::post($endpoint, [
            'api_key' => $this->api_key,
            'senderid' => $this->sender_id,
            'messages' => $messages
        ]);

        $responseArr = $response->json() ?: [];
        $responseStr = json_encode($responseArr, JSON_PRETTY_PRINT);

        if (isset($responseArr['status']) && $responseArr['status'] === 'SUCCESS') {
            return true;
        }

        Log::error('[' . __METHOD__ . "] Bulk SMS sending failed, Response: {$responseStr}");

        return false;
    }
}
