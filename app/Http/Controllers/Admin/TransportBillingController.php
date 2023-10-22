<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\TransportBillingRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportBillingController extends Controller
{
    public function __construct(
        protected TransportBillingRepository $transportBillRepository
    )
    {
    }

    public function generateBills()
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $timestamp = mktime(0, 0, 0, $i, 1);
            $monthValue = date('n', $timestamp); // Numeric representation of the month (1-12)
            $monthName = date('F', $timestamp);  // Full month name

            $months[] = [
                'value' => $monthValue,
                'name' => $monthName
            ];
        }

        return Inertia::render('TransportBill/GenerateBill', [
            'months' => $months
        ]);
    }

    public function storeGeneratedBills(Request $request)
    {

    }
}
