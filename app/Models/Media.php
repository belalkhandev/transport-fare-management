<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'mediable_type',
        'mediable_id',
        'name',
        'type',
        'src',
        'extension',
        'size'
    ];

    public function __toString():string
    {
        return $this->src;
    }

    public function getSrcAttribute($value)
    {
        return Storage::url($value);
    }

    public function mediable()
    {
        return $this->morphTo();
    }

}
