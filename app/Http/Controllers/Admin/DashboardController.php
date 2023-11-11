<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Repositories\PaymentRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TransportBillingRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function __construct(
        protected StudentRepository $studentRepository,
        protected TransportBillingRepository $transportBillingRepository,
        protected PaymentRepository $paymentRepository
    )
    {}


    public function index()
    {
        $totalStudents = $this->studentRepository->query()->count();
        $totalBills = $this->transportBillingRepository->query()
            ->select('amount', 'due_amount', 'is_paid')
            ->get();

        $totalBillAmount = $totalBills->sum(function ($query) {
            return $query->amount + $query->due_amount;
        });

        $totalCollection = $this->paymentRepository->query()->where('status', PaymentStatus::COMPLETED->value)->get()->sum('amount');

        $totalDue = $totalBillAmount - $totalCollection;

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $labels = [];
        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            $labels[] = $currentDate->format('d');
            $currentDate->addDay();
        }

        $paymentData = $this->paymentRepository->query()
            ->whereMonth('transaction_date', Carbon::now()->month)
            ->selectRaw('DATE(transaction_date) as date, SUM(amount) as total_amount')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $data = array_fill_keys($labels, 0);
        foreach ($paymentData as $payment) {
            $dateIndex = Carbon::parse($payment->date)->format('d');
            $data[$dateIndex] = $payment->total_amount;
        }

        $chartData = [
            'labels' => $labels,
            'data' => array_values($data)
        ];

        $latestPayments = $this->paymentRepository->query()
            ->with([
                'transportBill.student'
            ])
            ->where('status', PaymentStatus::COMPLETED->value)
            ->orderByDesc('transaction_date')
            ->latest('updated_at')
            ->take(10)
            ->get();

        return Inertia::render('Dashboard', [
            'total_students' => $totalStudents,
            'total_bills' => $totalBillAmount ?? 0,
            'total_collections' => $totalCollection ?? 0,
            'total_dues' => $totalDue ?? 0,
            'chart_data' => $chartData,
            'latest_payments' => $latestPayments
        ]);
    }
}
