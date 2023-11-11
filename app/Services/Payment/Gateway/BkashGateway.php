<?php

namespace App\Services\Payment\Gateway;

use App\Models\Payment;
use App\Models\Refund;
use App\Models\Settings;
use App\Services\Payment\Gateway\Contracts\Refundable;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BkashGateway extends PaymentGateway implements Refundable
{
    protected $url;
    protected $appKey;
    protected $appSecret;

    public function __construct()
    {
        $this->url = rtrim(config('services.bkash_pgw.api_url'), '/');
        $this->appKey = config('services.bkash_pgw.app_key');
        $this->appSecret = config('services.bkash_pgw.app_secret');
    }

    public function getServiceCharge(float $amount, $store_amount = 0): float
    {
        $percentage = Settings::getValue('bkash_pgw_charge_percentage', 1.5);

        return round($amount * ($percentage / 100), 2);
    }

    public function getInputFields($source): array
    {
        return [
            'gateway' => 'bkash_pgw',
            'gateway_trx_id' => $source['trxID'],
            'gateway_payment_id' => $source['paymentID'],
            'validation_id' => null,
            'currency' => $source['currency'] ?? 'BDT',
            'risk_level' => null,
            'ip_address' => request()->ip(),
            'status' => $source['transactionStatus'] === 'Completed' ? 'success' : 'fail',
            'paid_amount' => (float) $source['amount'],
            'trx_date' => Carbon::createFromFormat('Y-m-d\TH:i:s+', $source['paymentExecuteTime']),
        ];
    }

    public function createPayment(array $input)
    {
        $headers = $this->getBkashHeaders();

        $endpoint = "{$this->url}/create";

        $refNumber = Str::random(8);
        $this->logRequest(request(), $refNumber, $headers, $input);
        $response = Http::withHeaders($headers)->post($endpoint, $input);
        $this->logResponse($endpoint, $refNumber, request(), $response);

        return $response;
    }

    public function executePayment($paymentId)
    {
        $headers = $this->getBkashHeaders();

        $endpoint = "{$this->url}/execute";

        $refNumber = Str::random(8);
        $this->logRequest(request(), $refNumber, $headers);
        $response = Http::withHeaders($headers)->timeout(30)->post($endpoint, [
            'paymentID' => $paymentId,
        ]);
        $this->logResponse($endpoint, $refNumber, request(), $response);

        return $response;
    }

    public function queryPayment($paymentId)
    {
        $headers = $this->getBkashHeaders();

        $endpoint = "{$this->url}/payment/status";

        $refNumber = Str::random(8);
        $this->logRequest(request(), $refNumber, $headers);

        $response = Http::withHeaders($headers)->timeout(30)->post($endpoint, [
            'paymentID' => $paymentId,
        ]);

        $this->logResponse($endpoint, $refNumber, request(), $response);

        return $response;
    }

    public function initiateRefundProcess(Payment $payment, Refund $refund): ?array
    {
        $data = [
            'amount' => $payment->amount,
            'paymentID' => $payment->gateway_payment_id,
            'trxID' => $payment->gateway_trans_id,
            'sku' => $payment->trans_id,
            'reason' => $refund->note ?? 'Bill canceled',
        ];

        $headers = $this->getBkashHeaders();

        $endpoint = "{$this->url}/payment/refund";

        $refNumber = Str::random(8);
        $this->logRequest(request(), $refNumber, $headers, $data);
        $response = Http::withHeaders($headers)->post($endpoint, $data);

        $this->logResponse($endpoint, $refNumber, request(), $response);
        $responseArr = $response->json() ?: [];
        $refundTrxId = Arr::get($responseArr, 'refundTrxID');

        if ($refundTrxId) {
            $data = [
                'status' => 'refunded',
                'amount' => $responseArr['amount'],
                'charge' => $responseArr['charge'],
                'trx_id' => $refundTrxId,
                'process_initiated_at' => now(),
            ];

            $response = $this->queryPayment($payment->gateway_payment_id);
            $queryResponseArr = $response->json() ?: [];


            $contactNo = Arr::get($queryResponseArr, 'customerMsisdn');
            if ($contactNo) {
                $data['refunded_to'] = $contactNo;
            }

            return $data;
        }

        return null;
    }

    public function checkRefundStatus(Refund $refund): ?array
    {
        $data = [
            'paymentID' => $refund->order->payment->gateway_payment_id,
            'trxID' => $refund->order->payment->gateway_trx_id,
        ];

        $headers = $this->getBkashHeaders();

        $endpoint = "{$this->url}/payment/refund";

        $refNumber = Str::random(8);
        $this->logRequest(request(), $refNumber, $headers, $data);
        $response = Http::withHeaders($headers)->post($endpoint, $data);
        $this->logResponse($endpoint, $refNumber, request(), $response);

        $responseArr = $response->json() ?: [];

        if (isset($responseArr['refundTrxID'])) {
            $data = [
                'amount' => $responseArr['amount'],
                'charge' => $responseArr['charge'],
                'trx_id' => $responseArr['refundTrxID'],
                'refunded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s+', $responseArr['completedTime']),
            ];

            if ($responseArr['transactionStatus'] === 'Completed') {
                $data['status'] = 'refunded';
            }

            return $data;
        }

        return null;
    }

    private function getAccessToken()
    {
        return Cache::remember('bkash_access_token', config('services.bkash_pgw.token_lifetime'), function () {
            $accessToken = null;

            $data = [
                'app_key' => $this->appKey,
                'app_secret' => $this->appSecret,
            ];

            $headers = [
                'Accept' => 'application/json',
                'username' => config('services.bkash_pgw.username'),
                'password' => config('services.bkash_pgw.password'),
            ];

            $endpoint = $this->url . '/token/grant';

            $http = Http::withHeaders($headers);

            $attempts = 1;
            do {
                try {
                    $refNumber = Str::random(8);
                    $this->logRequest(request(), $refNumber, $headers, $data);
                    $response = $http->post($endpoint, $data);
                    $this->logResponse($endpoint, $refNumber, request(), $response);

                    $responseArr = $response->json() ?: [];
                    $accessToken = $responseArr['id_token'] ?? null;

                } catch (Exception $exception) {
                    Log::error($exception->getMessage() . $exception->getFile() . ':' . $exception->getLine());
                }
            } while (!$accessToken && $attempts++ < 2);

            return $accessToken;
        });
    }

    private function logResponse($uri, $refNumber, $request, $response)
    {
        $status = $response->status();

        $headers = json_encode(['headers' => $response->headers()]);

        $body = json_encode(['body' => $response->json() ?: []]);

        $message = "{$request->ip()} {$refNumber} [Response] - {$status} {$uri} {$headers} {$body}";

        if ($status >= 200 && $status < 300) {
            Log::channel('payment')->debug($message);
        } elseif ($status >= 300 && $status < 400) {
            Log::channel('payment')->info($message);
        } elseif ($status >= 400 && $status < 500) {
            Log::channel('payment')->error($message);
        } else {
            Log::channel('payment')->critical($message);
        }
    }

    private function getBkashHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => $this->getAccessToken(),
            'X-App-Key' => $this->appKey,
        ];
    }

    private function logRequest($request, $refNumber, $headers, $body = null)
    {
        $method = mb_strtoupper($request->getMethod());
        $uri = $request->getPathInfo();
        $headers = json_encode(['headers' => $headers]);
        $body = json_encode(['body' => $body]);
        $message = "{$request->ip()} {$refNumber} [Request] {$method} - {$uri} {$headers} {$body}";

        Log::channel('payment')->debug($message);
    }
}
