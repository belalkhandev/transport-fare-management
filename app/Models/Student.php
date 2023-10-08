<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'father_name',
        'mother_name',
        'contact_no',
        'email',
        'emergency_contact',
        'dob',
        'gender',
        'blood_group',
        'address_line_1',
        'address_line_2',
        'is_active'
    ];

    public function academicPlans()
    {
        return $this->belongsToMany(AcademicPlan::class, 'student_academic_plan', 'academic_plan_id', 'student_id');
    }

    public function academicPlan()
    {
        return $this->academicPlan()->latest()->first();
    }
}
