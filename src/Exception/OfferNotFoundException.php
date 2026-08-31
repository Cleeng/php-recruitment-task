<?php

declare(strict_types=1);

namespace App\Exception;

final class OfferNotFoundException extends ApiException
{
    public static function withId(int $id): self
    {
        return new self('offer_not_found', sprintf('Offer %d not found.', $id), 404);
    }
}
