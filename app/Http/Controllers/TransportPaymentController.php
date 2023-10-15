<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportPaymentController extends Controller
{
    public function __construct()
    {
    }


    public function index($transportBillId)
    {
        return Inertia::render('TransportPayment/Index', [
            'transport_bill_id' => $transportBillId
        ]);
    }
}
