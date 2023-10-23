<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\StudentRepository;
use App\Repositories\TransportBillingRepository;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportBillingController extends Controller
{
    public function __construct(
        protected TransportBillingRepository $transportBillRepository,
        protected StudentRepository $studentRepository
    )
    {
    }

    public function generateBills()
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $timestamp = mktime(0, 0, 0, $i, 1);
            $months[] = [
                'value' => date('n', $timestamp),
                'name' => date('F', $timestamp)
            ];
        }

        $currentYear =  date('Y');
        $lastYear = $currentYear - 1;
        $nextYear = $currentYear + 1;

        $years[] = [
            'value' => $lastYear,
            'name' => $lastYear
        ];

        $years[] = [
            'value' => $currentYear,
            'name' => $currentYear
        ];

        $years[] = [
            'value' => $nextYear,
            'name' => $nextYear
        ];

        return Inertia::render('TransportBill/GenerateBill', [
            'months' => $months,
            'years' => $years
        ]);
    }

    public function storeGeneratedBills(Request $request)
    {
        $request->validate([
            'month' => ['required'],
            'year' => 'required'
        ]);

        try {
            $students = $this->studentRepository->getActiveStudents();
            $this->transportBillRepository->generateMonthlyBill($request, $students);
        }catch (Exception $e) {

        }
    }
}
