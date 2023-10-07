<?php

namespace App\Repositories;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Payment::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $paymentId)
    {
        return $this->query()->findOrFail($paymentId)->update([

            ]);
    }

    public function deleteByRequest($paymentId)
    {
        return $this->query()->findOrFail($paymentId)->delete();
    }

}
