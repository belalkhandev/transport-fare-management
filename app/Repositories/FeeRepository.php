<?php

namespace App\Repositories;

use App\Models\Fee;
use Illuminate\Http\Request;

class FeeRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Fee::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $feeId)
    {
        return $this->query()->findOrFail($feeId)->update([

            ]);
    }

    public function deleteByRequest($feeId)
    {
        return $this->query()->findOrFail($feeId)->delete();
    }

}
