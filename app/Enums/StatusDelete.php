<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class StatusDelete extends Enum
{
    const DELETE = 1;
    const NORMAL = 0;
}
