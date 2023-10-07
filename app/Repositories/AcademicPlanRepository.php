<?php

namespace App\Repositories;

use App\Models\AcademicPlan;
use Illuminate\Http\Request;

class AcademicPlanRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return AcademicPlan::class;
    }

    public function getByPaginate($limit = 15)
    {
        return $this->query()
            ->with('academicYear', 'academicClass', 'academicGroup', 'academicSection')
            ->latest()
            ->paginate($limit);
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $academicPlanId)
    {
        return $this->query()->findOrFail($academicPlanId)->update([

            ]);
    }

    public function deleteByRequest($academicPlanId)
    {
        return $this->query()->findOrFail($academicPlanId)->delete();
    }

}
