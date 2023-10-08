<?php

namespace App\Repositories;

use App\Models\AcademicYear;
use Carbon\Carbon;
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
            'name' => $request->get('name'),
            'start_date' => Carbon::parse($request->get('start_date'))->format('Y-m-d'),
            'end_date' => Carbon::parse($request->get('end_date'))->format('Y-m-d'),
            'is_active' => $request->get('is_active') ? 1 : 0
        ]);
    }

    public function updateByRequest(Request $request, $academicYearId)
    {
        return $this->query()->findOrFail($academicYearId)?->update([
            'name' => $request->get('name'),
            'start_date' => Carbon::parse($request->get('start_date'))->format('Y-m-d'),
            'end_date' => Carbon::parse($request->get('end_date'))->format('Y-m-d'),
            'is_active' => $request->get('is_active') ? 1 : 0
        ]);
    }

    public function deleteByRequest($academicYearId)
    {
        return $this->query()->findOrFail($academicYearId)?->delete();
    }

}
