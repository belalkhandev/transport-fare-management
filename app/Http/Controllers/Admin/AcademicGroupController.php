<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AcademicGroupRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicGroupController extends Controller
{
    public function __construct(
        protected AcademicGroupRepository $academicGroupRepository
    )
    {
    }

    public function index()
    {
        $academicGroups = $this->academicGroupRepository->getByPaginate();

        return Inertia::render('Academic/GroupList', [
            'academic_groups' => $academicGroups
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:academic_groups,name']
        ]);

        $this->academicGroupRepository->storeByRequest($request);

        return to_route('academic-group.index');
    }

    public function update(Request $request, $academicGroupId)
    {
        $request->validate([
            'name' => ['required', 'unique:academic_groups,name,'.$academicGroupId]
        ]);

        $this->academicGroupRepository->updateByRequest($request, $academicGroupId);

        return to_route('academic-group.index');
    }

    public function destroy($academicGroupId)
    {
        $this->academicGroupRepository->deleteByRequest($academicGroupId);

        return to_route('academic-group.index');
    }
}
