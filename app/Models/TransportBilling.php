<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportBilling extends Model
{
    use HasFactory;

    protected $appends = ['formatted_month_year'];

    protected $fillable = [
        'student_id',
        'academic_plan_id',
        'month',
        'year',
        'due_date',
        'amount',
        'due_amount',
        'is_paid',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getFormattedMonthYearAttribute()
    {
        return Carbon::create($this->year, $this->month, 1)->format('F Y');

    }
}
