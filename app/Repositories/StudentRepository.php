<?php

namespace App\Repositories;

use App\Models\Student;
use Carbon\Carbon;
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

    public function getByPaginate($searchKey = null, $limit = 15)
    {
        return $this->query()
            ->select('students.*')
            ->with([
                    'academicPlans' => function ($query) {
                            $query->latest();
                        },
                    'transportFee.fee.area'
                ]
            )
            ->when($searchKey, function ($query) use ($searchKey) {
                $query->where('student_id', 'LIKE', '%'.$searchKey.'%')->orWhere('contact_no', 'LIKE', '%'.$searchKey.'%')->orWhere('name', 'LIKE', '%'.$searchKey.'%');
            })
            ->orderBy('is_active')
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

    public function getByStudentId($studentId)
    {
        return $this->query()
            ->with([
                'transportFee.fee.area',
                'academicPlans' => function ($query) { $query->latest(); },
                'academicPlans.academicYear',
                'academicPlans.academicClass',
                'academicPlans.academicGroup',
                'academicPlans.academicSection',
            ])
            ->ofStudentId($studentId)
            ->firstOrFail();
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

    public function storeByImportData($data)
    {
        return $this->query()->create([
            'student_id' => $data['student_id'],
            'name' => $data['name'],
            'father_name' => $data['father_name'],
            'mother_name' => $data['mother_name'],
            'dob' => isset($data['dob']) && $data['dob'] ? Carbon::parse($data['dob'])->format('Y-m-d') : null,
            'gender' => $data['gender'] ?? null,
            'blood_group' => $data['blood_group'] ?? null,
            'contact_no' => $data['contact_no'],
            'emergency_contact' => $data['emergency_contact'] ?? null,
            'email' => $data['email'] ?? null,
            'address_line_1' => $data['address_line_1'] ?? null,
            'address_line_2' => $data['address_line_2'] ?? null,
        ]);
    }

    public function deleteByRequest($studentId)
    {
        return $this->query()->findOrFail($studentId)?->delete();
    }

    public function getActiveStudents()
    {
        return $this->query()
            ->with(['academicPlans' => function($query) { return $query->latest(); }, 'transportFee'])
            ->active()
            ->get();
    }

}
