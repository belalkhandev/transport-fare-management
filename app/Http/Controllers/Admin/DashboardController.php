<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\StudentRepository;
use App\Repositories\TransportBillingRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function __construct(
        protected StudentRepository $studentRepository,
        protected TransportBillingRepository $transportBillingRepository
    )
    {}


    public function index()
    {
        $totalStudents = $this->studentRepository->query()->count();

        return Inertia::render('Dashboard', [
            'total_student' => $totalStudents,
            'total_bills' => 0,
            'total_collections' => 0,
            'total_due' => 0
        ]);
    }
}
