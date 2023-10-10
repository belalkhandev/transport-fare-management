<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AcademicVersion;
use App\Enums\BloodGroup;
use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use App\Repositories\AcademicPlanRepository;
use App\Repositories\AreaRepository;
use App\Repositories\FeeRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportFeeRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function __construct(
        protected AcademicPlanRepository $academicPlanRepository,
        protected FeeRepository $feeRepository,
        protected StudentRepository $studentRepository,
        protected TransportFeeRepository $transportFeeRepository
    )
    {
    }

    public function index()
    {
        $students = $this->studentRepository->getByPaginate();

        return Inertia::render('Student/Index', [
            'students' => $students
        ]);
    }

    public function show($studentId)
    {
        $student = $this->studentRepository->getById($studentId);

        return Inertia::render('Student/Show', [
            'student' => $student
        ]);
    }

    public function create()
    {
        $academicPlans = $this->academicPlanRepository->query()
            ->latest()
            ->get();

        $fees = $this->feeRepository->query()->with('area')->get();

        return Inertia::render('Student/Create', [
            'academic_plans' => $academicPlans,
            'gender' => GenderEnum::values(),
            'blood_group' => BloodGroup::values(),
            'fees' => $fees
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'unique:students,student_id'],
            'name' => ['required'],
            'gender' => ['required'],
            'father_name' => ['required'],
            'mother_name' => ['required'],
            'contact_no' => ['required'],
            'address_line_1' => ['required'],
            'academic_plan_id' => ['required'],
        ]);

        $student = $this->studentRepository->storeByRequest($request);

        if ($student && $request->has('academic_plan_id')) {
            $student->academicPlans()->attach([$request->get('academic_plan_id')]);
        }

        if ($student && $request->fee_id) {
            $this->transportFeeRepository->storeByRequestAndStudentId($request, $student->id);
        }

        return to_route('student.index');
    }

    public function edit($studentId)
    {
        $student = $this->studentRepository->findOrFail($studentId);
        $academicPlans = $this->academicPlanRepository->query()
            ->latest()
            ->get();

        $fees = $this->feeRepository->query()->with('area')->get();

        return Inertia::render('Student/Edit', [
            'academic_plans' => $academicPlans,
            'gender' => GenderEnum::values(),
            'blood_group' => BloodGroup::values(),
            'fees' => $fees,
            'student' => $student
        ]);
    }

    public function update(Request $request, $studentId)
    {
        $request->validate([
            'student_id' => ['required', 'unique:students,student_id,'.$studentId],
            'name' => ['required'],
            'gender' => ['required'],
            'father_name' => ['required'],
            'mother_name' => ['required'],
            'contact_no' => ['required'],
            'address_line_1' => ['required'],
            'academic_plan_id' => ['required'],
        ]);

        $this->studentRepository->updateByRequest($request, $studentId);

        return to_route('student.edit', $studentId);
    }

    public function destroy($studentId)
    {
        $this->studentRepository->deleteByRequest($studentId);

        return to_route('student.index');
    }

    public function bulkImport()
    {
        $academicPlans = $this->academicPlanRepository->query()
            ->latest()
            ->get();

        $fees = $this->feeRepository->query()->with('area')->get();

        return Inertia::render('Student/Create', [
            'academic_plans' => $academicPlans,
            'gender' => GenderEnum::values(),
            'blood_group' => BloodGroup::values(),
            'fees' => $fees
        ]);
    }
}