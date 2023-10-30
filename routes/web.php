<?php

use App\Http\Controllers\Web\PaymentController;
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
Route::get('/transport-bill/{studentId}/payment/{transId}', [TransportPaymentController::class, 'index'])->name('student.transport-bill.payment');

//Bkash Payment Gateway
Route::post('/transport-bills/payment/createBkashPayment', [PaymentController::class, 'create'])->name('create.payment');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/{transId}/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/{transId}/completed', [PaymentController::class, 'paymentCompleted'])->name('payment.completed');
Route::get('/payment/{transId}/canceled', [PaymentController::class, 'paymentCanceled'])->name('payment.canceled');
Route::get('/payment/{transId}/failed', [PaymentController::class, 'paymentFailed'])->name('payment.failed');
