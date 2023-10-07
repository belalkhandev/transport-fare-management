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
            'name' => $request->name,
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }


    public function updateByRequest(Request $request, $academicSectionId)
    {
        return $this->query()->findOrFail($academicSectionId)?->update([
            'name' => $request->name,
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }

    public function deleteByRequest($academicSectionId)
    {
        return $this->query()->findOrFail($academicSectionId)?->delete();
    }

}
