<?php

namespace App\Enums;

use App\Enums\Concerns\EnumAttributes;

enum GenderEnum: string
{
    use EnumAttributes;

    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

}
