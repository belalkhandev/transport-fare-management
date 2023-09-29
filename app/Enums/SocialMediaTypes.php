<?php

namespace App\Enums;

use App\Enums\Concerns\EnumAttributes;

enum SocialMediaTypes: string
{
    use EnumAttributes;

    case FACEBOOK = 'facebook';
    case INSTAGRAM = 'instagram';
    case TWITTER = 'twitter';
    case YOUTUBE = 'youtube';
    case LINKEDIN = 'linkedin';

}
