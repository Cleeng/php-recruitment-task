<?php

declare(strict_types=1);

namespace App\Exception;

final class AlreadySubscribedException extends ApiException
{
    public static function for(int $customerId, int $offerId): self
    {
        return new self(
            'already_subscribed',
            sprintf('Customer %d already has an active subscription for offer %d.', $customerId, $offerId),
            409,
        );
    }
}
