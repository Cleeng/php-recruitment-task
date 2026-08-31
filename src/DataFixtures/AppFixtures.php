<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\BillingPeriod;
use App\Entity\Customer;
use App\Entity\Offer;
use App\Entity\Subscription;
use App\Entity\SubscriptionStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $alice = new Customer('alice@example.com');
        $bob = new Customer('bob@example.com');
        $manager->persist($alice);
        $manager->persist($bob);

        $monthly = new Offer('Monthly Pass', 999, 'USD', BillingPeriod::P1M);
        $annual = new Offer('Annual Pass', 9900, 'USD', BillingPeriod::P1Y);
        $premium = new Offer('Monthly Premium', 1999, 'EUR', BillingPeriod::P1M);
        $legacy = new Offer('Legacy Plan', 499, 'USD', BillingPeriod::P1M, active: false);
        foreach ([$monthly, $annual, $premium, $legacy] as $offer) {
            $manager->persist($offer);
        }

        $today = new \DateTimeImmutable('today 10:00', new \DateTimeZone('UTC'));

        $manager->persist(new Subscription(
            $bob,
            $monthly,
            $today->modify('-15 months'),
            $today->modify('-14 months'),
            SubscriptionStatus::EXPIRED,
        ));
        $manager->persist(new Subscription(
            $bob,
            $premium,
            $today->modify('-7 days'),
            $today->modify('+23 days'),
        ));
        $manager->persist(new Subscription(
            $bob,
            $annual,
            $today->modify('-2 months'),
            $today->modify('+10 months'),
            SubscriptionStatus::CANCELLED,
            $today->modify('-5 days'),
        ));
        $manager->persist(new Subscription(
            $alice,
            $premium,
            new \DateTimeImmutable('2026-08-31T10:00:00+00:00'),
            new \DateTimeImmutable('2026-10-01T10:00:00+00:00'),
        ));

        $manager->flush();
    }
}
