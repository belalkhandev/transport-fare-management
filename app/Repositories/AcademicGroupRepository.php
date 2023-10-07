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

        ]);
    }


    public function updateByRequest(Request $request, $academicGroupId)
    {
        return $this->query()->findOrFail($academicGroupId)->update([

            ]);
    }

    public function deleteByRequest($academicGroupId)
    {
        return $this->query()->findOrFail($academicGroupId)->delete();
    }

}
