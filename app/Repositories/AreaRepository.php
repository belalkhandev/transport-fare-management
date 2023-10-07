<?php

namespace App\Repositories;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Area::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $areaId)
    {
        return $this->query()->findOrFail($areaId)->update([

            ]);
    }

    public function deleteByRequest($areaId)
    {
        return $this->query()->findOrFail($areaId)->delete();
    }

}
