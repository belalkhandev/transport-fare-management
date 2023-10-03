<?php

namespace App\Enums;

use App\Enums\Concerns\EnumAttributes;

enum DiscountType: string
{
    use EnumAttributes;

    case AMOUNT = 'amount';
    case PERCENT = 'percent';

}
