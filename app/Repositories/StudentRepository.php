<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentRepository extends Repository
{
    /**
     * @inheritDoc
     */
    public function model()
    {
        return Student::class;
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([

        ]);
    }


    public function updateByRequest(Request $request, $studentId)
    {
        return $this->query()->findOrFail($studentId)->update([

            ]);
    }

    public function deleteByRequest($studentId)
    {
        return $this->query()->findOrFail($studentId)->delete();
    }

}
