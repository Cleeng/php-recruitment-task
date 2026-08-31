<?php

declare(strict_types=1);

namespace App\Exception;

final class CustomerNotFoundException extends ApiException
{
    public static function withId(int $id): self
    {
        return new self('customer_not_found', sprintf('Customer %d not found.', $id), 404);
    }
}
