<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'start_date',
        'end_date'
    ];

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeCurrentActiveYear(Builder $query)
    {
        return $query->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    }
}
