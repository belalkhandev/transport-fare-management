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
            'name' => $request->get('name'),
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }


    public function updateByRequest(Request $request, $areaId)
    {
        return $this->query()->findOrFail($areaId)?->update([
            'name' => $request->get('name'),
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }

    public function deleteByRequest($areaId)
    {
        return $this->query()->findOrFail($areaId)?->delete();
    }

}
