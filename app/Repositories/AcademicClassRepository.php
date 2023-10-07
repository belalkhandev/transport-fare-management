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
            'name' => $request->get('name'),
            'numeric_name' => $request->get('numeric_name', null),
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }


    public function updateByRequest(Request $request, $academicClassId)
    {
        return $this->query()->findOrFail($academicClassId)?->update([
            'name' => $request->get('name'),
            'numeric_name' => $request->get('numeric_name', null),
            'is_active' => $request->is_active ? 1 : 0
        ]);
    }

    public function deleteByRequest($academicClassId)
    {
        return $this->query()->findOrFail($academicClassId)?->delete();
    }

}
