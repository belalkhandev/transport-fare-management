<?php

namespace App\Enums;

use App\Enums\Concerns\EnumAttributes;

enum EducationLevel: string
{
    use EnumAttributes;

    case SCHOOL = 'school';
    case COLLEGE = 'college';

}
