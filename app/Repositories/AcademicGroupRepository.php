<?php

namespace App\Repositories;

use App\Models\AcademicGroup;
use Illuminate\Http\Request;

class AcademicGroupRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return AcademicGroup::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([
            'name' => $request->name,
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }


    public function updateByRequest(Request $request, $academicGroupId)
    {
        return $this->query()->findOrFail($academicGroupId)->update([
            'name' => $request->name,
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }

    public function deleteByRequest($academicGroupId)
    {
        return $this->query()->findOrFail($academicGroupId)->delete();
    }

}
