<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AcademicYearRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicYearController extends Controller
{
    public function __construct(
        protected AcademicYearRepository $academicYearRepository
    )
    {
    }

    public function index()
    {
        $academicYears = $this->academicYearRepository->getByPaginate();

        return Inertia::render('Academic/YearList', [
            'academic_years' => $academicYears
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:academic_years,name']
        ]);

        $this->academicYearRepository->storeByRequest($request);

        return to_route('academic-year.index');
    }

    public function update(Request $request, $academicYearId)
    {
        $academicYear = $this->academicYearRepository->query()
            ->findOrFail($academicYearId);

        $request->validate([
            'name' => ['required', 'unique:academic_years,name,'.$academicYear->id]
        ]);

        $this->academicYearRepository->updateByRequest($request, $academicYearId);

        return to_route('academic-year.index');
    }

    public function destroy($academicYearId)
    {
        $this->academicYearRepository->deleteByRequest($academicYearId);

        return to_route('academic-year.index');
    }
}
