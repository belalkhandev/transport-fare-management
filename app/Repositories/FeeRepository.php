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

    public function getByPaginate($limit = 15)
    {
        return $this->query()
            ->with('area')
            ->latest()
            ->paginate($limit);
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->updateOrCreate([
            'area_id' => $request->get('area_id'),
        ],[
            'amount' => $request->get('amount')
        ]);
    }

    public function deleteByRequest($feeId)
    {
        return $this->query()->findOrFail($feeId)?->delete();
    }

}
