<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\TransportFeeRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportFeeController extends Controller
{
    public function __construct(
        protected TransportFeeRepository $transportFeeRepository
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
}
