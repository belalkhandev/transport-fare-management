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

        ]);
    }


    public function updateByRequest(Request $request, $id)
    {
        return $this->query()->findOrFail($id)?->update([

            ]);
    }

    public function deleteByRequest($id)
    {
        return $this->query()->findOrFail($id)?->delete();
    }

}
