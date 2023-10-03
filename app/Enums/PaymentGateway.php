<?php

namespace App\Enums;

use App\Enums\Concerns\EnumAttributes;

enum PaymentGateway: string
{
    use EnumAttributes;

    case BKASH = 'bkash';
    case SSL_COMMERZ = 'ssl_commerz';

}
