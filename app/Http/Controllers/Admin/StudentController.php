<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AcademicVersion;
use App\Enums\BloodGroup;
use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use App\Repositories\AcademicPlanRepository;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function __construct(
        protected AcademicPlanRepository $academicPlanRepository,
        protected StudentRepository $studentRepository,
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

    public function create()
    {
        $academicPlans = $this->academicPlanRepository->query()
            ->latest()
            ->get();

        return Inertia::render('Student/Create', [
            'academic_plans' => $academicPlans,
            'gender' => GenderEnum::values(),
            'blood_group' => BloodGroup::values()
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

        if ($request->has('academic_plan_id')) {
            $student->academicPlans()->attach([$request->get('academic_plan_id')]);
        }

        return to_route('student.index');
    }

    public function edit($academicPlanId)
    {
        $academicPlan = $this->academicPlanRepository->findOrFail($academicPlanId);
        $academicYears = $this->academicYearRepository->query()->active()->latest()->get();
        $academicClasses = $this->academicClassRepository->query()->active()->orderBy('numeric_name')->get();
        $academicGroups = $this->academicGroupRepository->query()->active()->latest()->get();
        $academicSections = $this->academicSectionRepository->query()->active()->latest()->get();

        return Inertia::render('AcademicPlan/Edit', [
            'academic_years' => $academicYears,
            'academic_classes' => $academicClasses,
            'academic_groups' => $academicGroups,
            'academic_sections' => $academicSections,
            'versions' => AcademicVersion::values(),
            'academic_plan' => $academicPlan
        ]);
    }

    public function update(Request $request, $studentId)
    {
        $request->validate([
            'academic_year_id' => ['required'],
            'academic_class_id' => ['required'],
        ]);

        $this->studentRepository->updateByRequest($request, $studentId);

        return to_route('student.edit', $studentId);
    }

    public function destroy($studentId)
    {
        $this->studentRepository->deleteByRequest($studentId);

        return to_route('student.index');
    }
}
