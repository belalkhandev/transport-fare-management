<?php

namespace App\Enums;

use App\Enums\Concerns\EnumAttributes;

enum UserRoles: string
{
    use EnumAttributes;

    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';

}
