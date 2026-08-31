<?php

declare(strict_types=1);

namespace App\Entity;

enum SubscriptionStatus: string
{
    case ACTIVE = 'ACTIVE';
    case CANCELLED = 'CANCELLED';
    case EXPIRED = 'EXPIRED';
}
