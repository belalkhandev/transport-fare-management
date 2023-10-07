<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AreaRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AreaController extends Controller
{
    public function __construct(
        protected AreaRepository $areaRepository
    )
    {
    }

    public function index()
    {
        $areas = $this->areaRepository->getByPaginate();

        return Inertia::render('AreaList', [
            'areas' => $areas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:areas,name']
        ]);

        $this->areaRepository->storeByRequest($request);

        return to_route('area.index');
    }

    public function update(Request $request, $areaId)
    {
        $request->validate([
            'name' => ['required', 'unique:areas,name,'.$areaId]
        ]);

        $this->areaRepository->updateByRequest($request, $areaId);

        return to_route('area.index');
    }

    public function destroy($areaId)
    {
        $this->areaRepository->deleteByRequest($areaId);

        return to_route('area.index');
    }
}
