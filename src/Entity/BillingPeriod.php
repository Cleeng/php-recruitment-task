<?php

declare(strict_types=1);

namespace App\Entity;

enum BillingPeriod: string
{
    case P1M = 'P1M';
    case P1Y = 'P1Y';
}
