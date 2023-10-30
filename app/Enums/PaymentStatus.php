<?php

namespace App\Enums;

use App\Enums\Concerns\EnumAttributes;

enum PaymentStatus: string
{
    use EnumAttributes;

    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
    case REFUNDED = 'refunded';
}
