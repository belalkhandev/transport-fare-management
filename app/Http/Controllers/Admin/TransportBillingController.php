<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\PaymentRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportBillingRepository;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportBillingController extends Controller
{
    public function __construct(
        protected TransportBillingRepository $transportBillRepository,
        protected PaymentRepository $paymentRepository,
        protected StudentRepository $studentRepository
    )
    {
    }

    public function index(Request $request)
    {
        $bills = $this->transportBillRepository->query()
            ->select('transport_billings.*')
            ->with([
                'student',
                'payment'
            ])
            ->leftJoin('students', 'students.id', '=', 'transport_billings.student_id')
            ->leftJoin('payments', 'transport_billings.id', '=', 'payments.transport_billing_id')
            ->when($search = $request->search, function ($query) use ($search) {
                $query->where('students.student_id', 'LIKE', '%'.$search.'%')
                    ->orWhere('students.contact_no', 'LIKE', '%'.$search.'%')
                    ->orWhere('payments.trans_id', 'LIKE', '%'.$search.'%');
            })
            ->when($month = $request->month, function ($query) use ($month) {
                $query->where('transport_billings.month', $month);
            })
            ->when($year = $request->year, function ($query) use ($year) {
                $query->where('transport_billings.year', $year);
            })
            ->latest('transport_billings.created_at')
            ->paginate();

        $monthYear = $this->preparedMonthYear();

        return Inertia::render('TransportBill/Index', [
            'bills' => $bills,
            'months' => $monthYear['months'],
            'years' => $monthYear['years'],
            'filterData' => $request->all()
        ]);
    }

    public function paymentList()
    {
        $payments = $this->paymentRepository->query()
            ->with([
                'transportBill.student'
            ])
            ->latest()
            ->paginate();

        return Inertia::render('TransportBill/Payments', [
            'payments' => $payments
        ]);
    }

    public function generateBills()
    {
        $monthYear = $this->preparedMonthYear();

        return Inertia::render('TransportBill/GenerateBill', [
            'months' => $monthYear['months'],
            'years' => $monthYear['years']
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
            return $this->json($e->getMessage(), null, 400);
        }
    }

    private function preparedMonthYear(): array
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

        return [
            'months' => $months,
            'years' => $years
        ];
    }
}
