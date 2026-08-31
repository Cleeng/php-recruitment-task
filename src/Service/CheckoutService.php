<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Customer;
use App\Entity\Offer;
use App\Entity\Subscription;
use App\Exception\AlreadySubscribedException;
use App\Exception\OfferNotFoundException;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Clock\ClockInterface;

final class CheckoutService
{
    public function __construct(
        private readonly ClockInterface $clock,
        private readonly SubscriptionRepository $subscriptions,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function checkout(Customer $customer, Offer $offer): Subscription
    {
        if (!$offer->isActive()) {
            throw OfferNotFoundException::withId((int) $offer->getId());
        }

        if ($this->subscriptions->findActiveFor($customer, $offer) !== null) {
            throw AlreadySubscribedException::for((int) $customer->getId(), (int) $offer->getId());
        }

        $startedAt = $this->clock->now();
        $expiresAt = $startedAt->add(new \DateInterval($offer->getBillingPeriod()->value));

        $subscription = new Subscription($customer, $offer, $startedAt, $expiresAt);
        $this->entityManager->persist($subscription);
        $this->entityManager->flush();

        return $subscription;
    }
}
