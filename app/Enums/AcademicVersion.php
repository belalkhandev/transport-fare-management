<?php

namespace App\Enums;

use App\Enums\Concerns\EnumAttributes;

enum AcademicVersion: string
{
    use EnumAttributes;

    case ENGLISH = 'english';
    case BANGLA = 'bangla';

}
