<?php

declare(strict_types=1);

namespace App\Http;

use Symfony\Component\Validator\Constraints as Assert;

final class CheckoutRequest
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\Positive]
        public ?int $customerId = null,
        #[Assert\NotNull]
        #[Assert\Positive]
        public ?int $offerId = null,
    ) {
    }
}
