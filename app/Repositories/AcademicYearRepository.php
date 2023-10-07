<?php

namespace App\Repositories;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return AcademicYear::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([
            'name' => $request->name,
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }

    public function updateByRequest(Request $request, $academicYearId)
    {
        return $this->query()->findOrFail($academicYearId)?->update([
            'name' => $request->name,
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }

    public function deleteByRequest($academicYearId)
    {
        return $this->query()->findOrFail($academicYearId)?->delete();
    }

}
