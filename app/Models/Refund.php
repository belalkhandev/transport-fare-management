<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'gateway_payment_id',
        'refund_trans_id',
        'refunded_to',
        'amount',
        'charge',
        'status',
        'note',
        'process_initiated_at',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
