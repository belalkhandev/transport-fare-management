<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AcademicVersion;
use App\Enums\BloodGroup;
use App\Enums\GenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Repositories\AcademicPlanRepository;
use App\Repositories\AreaRepository;
use App\Repositories\FeeRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportFeeRepository;
use App\Services\StudentImport;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function __construct(
        protected AcademicPlanRepository $academicPlanRepository,
        protected FeeRepository $feeRepository,
        protected StudentRepository $studentRepository,
        protected TransportFeeRepository $transportFeeRepository,
        protected StudentImport $studentImport
    )
    {
    }

    public function index(Request $request)
    {
        $students = $this->studentRepository->getByPaginate(searchKey: $request->search ?? null);

        return Inertia::render('Student/Index', [
            'students' => $students,
            'filterData' => $request->all()
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

        $fees = $this->feeRepository->query()
            ->select('fees.*')
            ->with('area')
            ->leftJoin('areas', 'areas.id', '=', 'fees.area_id')
            ->orderBy('areas.name')
            ->get();

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
            'contact_no' => ['required']
        ]);

        $student = $this->studentRepository->storeByRequest($request);

        if ($student && $request->filled('academic_plan_id')) {
            $student->academicPlans()->attach([$request->get('academic_plan_id')]);
        }

        if ($student && $request->fee_id) {
            $this->transportFeeRepository->storeByRequestAndStudentId($request, $student->id);
        }

        return to_route('student.index');
    }

    public function edit($studentId)
    {
        $student = $this->studentRepository->query()
            ->with([
                'academicPlans' => function ($query) {
                   $query->latest();
                },
                'transportFee'
            ])
            ->findOrFail($studentId);

        $academicPlans = $this->academicPlanRepository->query()
            ->latest()
            ->get();

        $fees = $this->feeRepository->query()
            ->select('fees.*')
            ->with('area')
            ->leftJoin('areas', 'areas.id', '=', 'fees.area_id')
            ->orderBy('areas.name')
            ->get();

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
            'contact_no' => ['required']
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
        return Inertia::render('Student/BulkImport');
    }

    public function storeBulkImport(ImportRequest $request)
    {
        try{
            $students = $this->studentImport->importCsv($request->file('import_file'));
        }catch (Exception $e) {
            return to_route('student.import')
                ->withErrors(['message' => $e->getMessage()]);
        }

        if (count($students) === 0) {
            return to_route('student.import')
                ->withErrors(['message' => 'No new student  to be import']);
        }

        return to_route('student.import')
            ->with('message', count($students)." New students imported successfully");
    }
}
