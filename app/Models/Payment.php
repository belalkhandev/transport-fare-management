<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transport_billing_id',
        'trans_id',
        'gateway',
        'gateway_payment_id',
        'gateway_trans_id',
        'currency',
        'amount',
        'transaction_date',
        'status',
    ];

    public function transportBill()
    {
        return $this->belongsTo(TransportBilling::class, 'transport_billing_id');
    }
}
