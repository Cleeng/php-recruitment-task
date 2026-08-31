<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\Offer;
use App\Entity\Subscription;
use App\Entity\SubscriptionStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<Subscription> */
class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function findActiveFor(Customer $customer, Offer $offer): ?Subscription
    {
        return $this->findOneBy([
            'customer' => $customer,
            'offer' => $offer,
            'status' => SubscriptionStatus::ACTIVE,
        ]);
    }

    /** @return Subscription[] */
    public function findAllForCustomer(Customer $customer): array
    {
        return $this->findBy(['customer' => $customer], ['id' => 'ASC']);
    }
}
