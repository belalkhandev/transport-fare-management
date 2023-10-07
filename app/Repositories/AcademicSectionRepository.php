<?php

namespace App\Repositories;

use App\Models\AcademicSection;
use Illuminate\Http\Request;

class AcademicSectionRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return AcademicSection::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $academicSectionId)
    {
        return $this->query()->findOrFail($academicSectionId)->update([

            ]);
    }

    public function deleteByRequest($academicSectionId)
    {
        return $this->query()->findOrFail($academicSectionId)->delete();
    }

}
