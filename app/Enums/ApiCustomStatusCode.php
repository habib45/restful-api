<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ApiCustomStatusCode extends Enum
{
    const SUCCESS              =   200;
    const INSUFFICIENT_BALANCE =   413;
}
