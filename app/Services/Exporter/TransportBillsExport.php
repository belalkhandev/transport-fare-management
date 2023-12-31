<?php

namespace App\Services\Exporter;

use Barryvdh\DomPDF\Facade\Pdf;

class TransportBillsExport
{
    public function exportPDF($bills, $totalAmount, $requestData)
    {
        $pdf = Pdf::loadView('exports.transport-bills', [
            'bills' => $bills,
            'totalAmount' => $totalAmount ?? 0,
            'requestData' => $requestData
        ])->setPaper('a4');

        return $pdf->download('transport-bill-reports-'.now('Asia/Dhaka')->format('Y-m-d-h-i-s').'.pdf');
    }
}
