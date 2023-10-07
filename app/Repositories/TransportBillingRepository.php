<?php

namespace App\Repositories;

use App\Models\TransportBilling;
use Illuminate\Http\Request;

class TransportBillingRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return TransportBilling::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $transportBillingId)
    {
        return $this->query()->findOrFail($transportBillingId)->update([

            ]);
    }

    public function deleteByRequest($transportBillingId)
    {
        return $this->query()->findOrFail($transportBillingId)->delete();
    }

}
