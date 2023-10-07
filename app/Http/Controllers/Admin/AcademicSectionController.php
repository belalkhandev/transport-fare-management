<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AcademicSectionRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicSectionController extends Controller
{
    public function __construct(
        protected AcademicSectionRepository $academicSectionRepository
    )
    {
    }

    public function index()
    {
        $academicSections = $this->academicSectionRepository->getByPaginate();

        return Inertia::render('Academic/SectionList', [
            'academic_sections' => $academicSections
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:academic_sections,name']
        ]);

        $this->academicSectionRepository->storeByRequest($request);

        return to_route('academic-section.index');
    }

    public function update(Request $request, $academicSectionId)
    {
        $request->validate([
            'name' => ['required', 'unique:academic_sections,name,'.$academicSectionId]
        ]);

        $this->academicSectionRepository->updateByRequest($request, $academicSectionId);

        return to_route('academic-section.index');
    }

    public function destroy($academicSectionId)
    {
        $this->academicSectionRepository->deleteByRequest($academicSectionId);

        return to_route('academic-section.index');
    }
}
