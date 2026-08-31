<?php

declare(strict_types=1);

namespace App\Http;

use App\Entity\Offer;

final class OfferJson
{
    /** @return array{id: int|null, title: string, price: int, currency: string, billingPeriod: string} */
    public static function from(Offer $offer): array
    {
        return [
            'id' => $offer->getId(),
            'title' => $offer->getTitle(),
            'price' => $offer->getPrice(),
            'currency' => $offer->getCurrency(),
            'billingPeriod' => $offer->getBillingPeriod()->value,
        ];
    }
}
