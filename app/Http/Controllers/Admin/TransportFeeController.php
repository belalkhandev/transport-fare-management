<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\FeeRepository;
use App\Repositories\TransportFeeRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportFeeController extends Controller
{
    public function __construct(
        protected TransportFeeRepository $transportFeeRepository,
        protected FeeRepository $feeRepository
    )
    {

    }

    public function index()
    {
        $transportFees = $this->transportFeeRepository->getByPaginate();

        return Inertia::render('TransportFee/Index', [
            'transport_fees' => $transportFees
        ]);
    }

    public function edit($transportFeeId)
    {
        $transportFee = $this->transportFeeRepository->query()
            ->with('student')
            ->findOrFail($transportFeeId);

        $fees = $this->feeRepository->query()
            ->select('fees.*')
            ->with('area')
            ->leftJoin('areas', 'areas.id', '=', 'fees.area_id')
            ->orderBy('areas.name')
            ->get();

        return Inertia::render('TransportFee/Edit', [
            'transport_fee' => $transportFee,
            'fees' => $fees
        ]);
    }

    public function update(Request $request, $transportFeeId)
    {
        $request->validate([
            'fee_id' => 'required'
        ]);

        $this->transportFeeRepository->updateByRequest($request, $transportFeeId);

        return to_route('transport-fee.edit', $transportFeeId);
    }
}
