<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        return $this->belongsToMany(AcademicPlan::class, 'student_academic_plan', 'student_id', 'academic_plan_id');
    }

    public function academicPlan()
    {
        return $this->academicPlan()->latest()->first();
    }

    public function transportFee()
    {
        return $this->hasOne(TransportFee::class);
    }

    public function scopeOfStudentId(Builder $builder, $studentId)
    {
        return $builder->where('student_id', $studentId);
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('is_active', 1);
    }
}
