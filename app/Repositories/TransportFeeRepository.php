<?php

namespace App\Repositories;

use App\Models\TransportFee;
use Illuminate\Http\Request;

class TransportFeeRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return TransportFee::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $transportFeeId)
    {
        return $this->query()->findOrFail($transportFeeId)->update([

            ]);
    }

    public function deleteByRequest($transportFeeId)
    {
        return $this->query()->findOrFail($transportFeeId)->delete();
    }

}
