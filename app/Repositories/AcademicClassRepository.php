<?php

namespace App\Repositories;

use App\Models\AcademicClass;
use Illuminate\Http\Request;

class AcademicClassRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return AcademicClass::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $academicClassId)
    {
        return $this->query()->findOrFail($academicClassId)->update([

            ]);
    }

    public function deleteByRequest($academicClassId)
    {
        return $this->query()->findOrFail($academicClassId)->delete();
    }

}
