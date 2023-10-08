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
        $academicGroups = $this->academicGroupRepository->query()->active()->orderBy('name')->get();
        $academicSections = $this->academicSectionRepository->query()->active()->orderBy('name')->get();

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

        return to_route('academic-plan.index');
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

    public function update(Request $request, $academicPlanId)
    {
        $request->validate([
            'academic_year_id' => ['required'],
            'academic_class_id' => ['required'],
        ]);

        $this->academicPlanRepository->updateByRequest($request, $academicPlanId);

        return to_route('academic-plan.edit', $academicPlanId);
    }

    public function destroy($feeId)
    {
        $this->academicPlanRepository->deleteByRequest($feeId);

        return to_route('academic-plan.index');
    }
}
