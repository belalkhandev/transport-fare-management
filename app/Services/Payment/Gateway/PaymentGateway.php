<?php

namespace App\Services\Payment\Gateway;

abstract class PaymentGateway
{
    abstract public function getServiceCharge(float $amount, float $store_amount = 0): float;

    abstract public function getInputFields(array $source): array;
}
