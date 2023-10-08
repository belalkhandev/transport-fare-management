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
        return $this->query()->firstOrCreate([
            'academic_year_id' => $request->get('academic_year_id'),
            'academic_class_id' => $request->get('academic_class_id'),
            'academic_group_id' => $request->get('academic_group_id'),
            'academic_section_id' => $request->get('academic_section_id'),
            'academic_version' => $request->get('academic_version'),
        ]);
    }


    public function updateByRequest(Request $request, $academicPlanId)
    {
        return $this->query()->findOrFail($academicPlanId)?->update([
            'academic_year_id' => $request->get('academic_year_id'),
            'academic_class_id' => $request->get('academic_class_id'),
            'academic_group_id' => $request->get('academic_group_id'),
            'academic_section_id' => $request->get('academic_section_id'),
            'academic_version' => $request->get('academic_version'),
        ]);
    }

    public function deleteByRequest($academicPlanId)
    {
        return $this->query()->findOrFail($academicPlanId)?->delete();
    }

}
