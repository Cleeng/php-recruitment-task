<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column(length: 255)]
        private string $title,
        #[ORM\Column]
        private int $price,
        #[ORM\Column(length: 3)]
        private string $currency,
        #[ORM\Column(length: 3, enumType: BillingPeriod::class)]
        private BillingPeriod $billingPeriod,
        #[ORM\Column]
        private bool $active = true,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getBillingPeriod(): BillingPeriod
    {
        return $this->billingPeriod;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
