<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'academic_class_id',
        'academic_group_id',
        'academic_section_id',
        'academic_version'
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class);
    }
    public function academicGroup()
    {
        return $this->belongsTo(AcademicGroup::class);
    }
    public function academicSection()
    {
        return $this->belongsTo(AcademicSection::class);
    }
}
