<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\AreaRepository;
use App\Repositories\FeeRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeeController extends Controller
{
    public function __construct(
        protected FeeRepository $feeRepository,
        protected AreaRepository $areaRepository
    )
    {
    }

    public function index()
    {
        $fees = $this->feeRepository->getByPaginate();
        $areas = $this->areaRepository->query()
            ->active()
            ->orderBy('name')
            ->get();

        return Inertia::render('FeeList', [
            'fees' => $fees,
            'areas' => $areas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'area_id' => ['required'],
            'amount' => ['required']
        ]);

        $this->feeRepository->storeByRequest($request);

        return to_route('fee.index');
    }

    public function update(Request $request, $feeId)
    {
        $request->validate([
            'area_id' => ['required'],
            'amount' => ['required']
        ]);

        $this->feeRepository->storeByRequest($request);

        return to_route('fee.index');
    }

    public function destroy($feeId)
    {
        $this->feeRepository->deleteByRequest($feeId);

        return to_route('fee.index');
    }
}
