<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportBilling extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_plan_id',
        'month',
        'year',
        'due_date',
        'amount',
        'is_paid',
    ];
}
