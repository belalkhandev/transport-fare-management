<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AcademicVersion;
use App\Http\Controllers\Controller;
use App\Repositories\AcademicClassRepository;
use App\Repositories\AcademicGroupRepository;
use App\Repositories\AcademicPlanRepository;
use App\Repositories\AcademicSectionRepository;
use App\Repositories\AcademicYearRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicPlanController extends Controller
{
    public function __construct(
        protected AcademicYearRepository $academicYearRepository,
        protected AcademicClassRepository $academicClassRepository,
        protected AcademicGroupRepository $academicGroupRepository,
        protected AcademicSectionRepository $academicSectionRepository,
        protected AcademicPlanRepository $academicPlanRepository
    )
    {
    }

    public function index()
    {
        $academicPlans = $this->academicPlanRepository->getByPaginate();

        return Inertia::render('AcademicPlan/Index', [
            'academic_plans' => $academicPlans
        ]);
    }

    public function create()
    {
        $academicYears = $this->academicYearRepository->query()->active()->latest()->get();
        $academicClasses = $this->academicClassRepository->query()->active()->orderBy('numeric_name')->get();
        $academicGroups = $this->academicGroupRepository->query()->active()->latest()->get();
        $academicSections = $this->academicSectionRepository->query()->active()->latest()->get();

        return Inertia::render('AcademicPlan/Create', [
            'academic_years' => $academicYears,
            'academic_classes' => $academicClasses,
            'academic_groups' => $academicGroups,
            'academic_sections' => $academicSections,
            'versions' => AcademicVersion::values(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => ['required'],
            'academic_class_id' => ['required'],
        ]);

        $this->academicPlanRepository->storeByRequest($request);

        return to_route('fee.index');
    }

    public function edit()
    {
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
        ]);
    }

    public function update(Request $request, $feeId)
    {
        $request->validate([
            'area_id' => ['required'],
            'amount' => ['required']
        ]);

        $this->academicPlanRepository->storeByRequest($request);

        return to_route('fee.index');
    }

    public function destroy($feeId)
    {
        $this->academicPlanRepository->deleteByRequest($feeId);

        return to_route('fee.index');
    }
}
