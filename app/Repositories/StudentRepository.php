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

    public function getByPaginate($limit = 15)
    {
        return $this->query()
            ->with(['academicPlans' => function ($query) {
                $query->latest()->first();
            }])
            ->latest()
            ->paginate($limit);
    }

    public function getById($studentId)
    {
        return $this->query()
            ->with([
                'transportFee',
                'academicPlans' => function ($query) { $query->latest(); },
                'academicPlans.academicYear',
                'academicPlans.academicClass',
                'academicPlans.academicGroup',
                'academicPlans.academicSection',
            ])
            ->findOrFail($studentId);
    }

    public function storeByRequest(Request $request)
    {
        return $this->query()->create([
            'student_id' => $request->get('student_id'),
            'name' => $request->get('name'),
            'father_name' => $request->get('father_name'),
            'mother_name' => $request->get('mother_name'),
            'contact_no' => $request->get('contact_no'),
            'email' => $request->get('email'),
            'emergency_contact' => $request->get('emergency_contact'),
            'dob' => $request->get('dob'),
            'gender' => $request->get('gender'),
            'blood_group' => $request->get('blood_group'),
            'address_line_1' => $request->get('address_line_1'),
            'address_line_2' => $request->get('address_line_2'),
            'is_active' => $request->get('is_active')
        ]);
    }


    public function updateByRequest(Request $request, $studentId)
    {
        return $this->query()->findOrFail($studentId)?->update([
            'student_id' => $request->get('student_id'),
            'name' => $request->get('name'),
            'father_name' => $request->get('father_name'),
            'mother_name' => $request->get('mother_name'),
            'contact_no' => $request->get('contact_no'),
            'email' => $request->get('email'),
            'emergency_contact' => $request->get('emergency_contact'),
            'dob' => $request->get('dob'),
            'gender' => $request->get('gender'),
            'blood_group' => $request->get('blood_group'),
            'address_line_1' => $request->get('address_line_1'),
            'address_line_2' => $request->get('address_line_2'),
            'is_active' => $request->get('is_active')
        ]);
    }

    public function deleteByRequest($studentId)
    {
        return $this->query()->findOrFail($studentId)?->delete();
    }

}
