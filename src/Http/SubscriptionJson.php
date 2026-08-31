<?php

declare(strict_types=1);

namespace App\Http;

use App\Entity\Subscription;

final class SubscriptionJson
{
    /** @return array<string, mixed> */
    public static function from(Subscription $subscription): array
    {
        return [
            'id' => $subscription->getId(),
            'customerId' => $subscription->getCustomer()->getId(),
            'offerId' => $subscription->getOffer()->getId(),
            'status' => $subscription->getStatus()->value,
            'startedAt' => $subscription->getStartedAt()->format(DATE_ATOM),
            'expiresAt' => $subscription->getExpiresAt()->format(DATE_ATOM),
            'cancelledAt' => $subscription->getCancelledAt()?->format(DATE_ATOM),
        ];
    }
}
