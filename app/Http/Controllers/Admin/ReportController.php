<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SmsLogRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function __construct(
        protected SmsLogRepository $smsLogRepository
    )
    {
    }

    public function smsReports()
    {
        $reports = $this->smsLogRepository
            ->query()
            ->selectRaw( 'DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total_count, CEIL(SUM(CEIL(CHAR_LENGTH(message) / 160))) as sms_count')
            ->groupBy('month')
            ->orderByDesc('month')
            ->get();

        return Inertia::render('Reports/SmsReport', ['reports' => $reports]);
    }
}
