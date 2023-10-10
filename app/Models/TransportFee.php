<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'fee_id',
        'discounted_amount',
        'remarks'
    ];
}
