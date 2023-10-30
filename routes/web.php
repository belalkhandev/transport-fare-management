<?php

use App\Http\Controllers\TransportPaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/transport-bills/payments/{transId}', [TransportPaymentController::class, 'index'])->name('transport-bill.user.payment');
Route::get('/transport-bill/{studentId}/payment/{transactionBillNo}', [TransportPaymentController::class, 'index'])->name('student.transport-bill.payment');


