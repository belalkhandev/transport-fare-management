<?php

namespace App\Enums;

use App\Enums\Concerns\EnumAttributes;

enum BloodGroup: string
{
    use EnumAttributes;

    case APVE = 'A+ve';
    case ANVE = 'A-ve';
    case BPVE = 'B+ve';
    case BNVE = 'B-ve';
    case ABPVE = 'AB+ve';
    case ABNVE = 'AB-ve';
    case OPVE = 'O+ve';
    case ONVE = 'O-ve';

}
