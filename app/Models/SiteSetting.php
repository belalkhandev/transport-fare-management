<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref',
        'site_title',
        'logo',
        'favicon',
        'footer_logo',
        'footer_summary',
        'copyright_text',
        'facebook',
        'twitter',
        'youtube',
        'linkedin',
        'instagram',
    ];

    public function siteLogo()
    {
        return $this->belongsTo(Media::class, 'logo', 'id');
    }

    public function siteFavicon()
    {
        return $this->belongsTo(Media::class, 'favicon', 'id');
    }

    public function footerLogo()
    {
        return $this->belongsTo(Media::class, 'footer_logo', 'id');
    }
}
