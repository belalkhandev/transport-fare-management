<?php

namespace App\Services\Payment;

use App\Models\Settings;
use Illuminate\Validation\ValidationException;

class PaymentCalculator
{
    public function getVatAmount($amount)
    {
        return round($amount * ($this->getVatPercentage() / 100), 2);
    }

    public function getVatPercentage()
    {
        return Settings::getValue('vat_percentage', 5);
    }

    public function getAmountOfVatApplied($includedVatAmount)
    {
        $excludingVatAmount = $includedVatAmount / ($this->getVatPercentage() / 100 + 1);

        return round($includedVatAmount - $excludingVatAmount, 2);
    }

    public function getAmountWithVat($amount)
    {
        $vatAmount = $amount > 0 ? $this->getVatAmount($amount) : 0;

        return round($amount + $vatAmount, 2);
    }

    public function validateAmount($order, $amount)
    {
        if ((float) $amount !== (float) $order->payment->paid_amount) {
            throw ValidationException::withMessages(['amount' => 'Invalid amount']);
        }
    }
}
