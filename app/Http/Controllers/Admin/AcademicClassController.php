<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AcademicClassRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicClassController extends Controller
{
    public function __construct(
        protected AcademicClassRepository $academicClassRepository
    )
    {
    }

    public function index()
    {
        $academicClasses = $this->academicClassRepository->getByPaginate();

        return Inertia::render('Academic/ClassList', [
            'academic_classes' => $academicClasses
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:academic_classes,name']
        ]);

        $this->academicClassRepository->storeByRequest($request);

        return to_route('academic-class.index');
    }

    public function update(Request $request, $academicClassId)
    {
        $request->validate([
            'name' => ['required', 'unique:academic_classes,name,'.$academicClassId]
        ]);

        $this->academicClassRepository->updateByRequest($request, $academicClassId);

        return to_route('academic-class.index');
    }

    public function destroy($academicClassId)
    {
        $this->academicClassRepository->deleteByRequest($academicClassId);

        return to_route('academic-class.index');
    }
}
