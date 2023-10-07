<?php

namespace App\Repositories;

use App\Models\AcademicPlanStudent;
use Illuminate\Http\Request;

class AcademicPlanStudentRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return AcademicPlanStudent::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $academicPlanStudentId)
    {
        return $this->query()->findOrFail($academicPlanStudentId)->update([

            ]);
    }

    public function deleteByRequest($academicPlanStudentId)
    {
        return $this->query()->findOrFail($academicPlanStudentId)->delete();
    }

}
