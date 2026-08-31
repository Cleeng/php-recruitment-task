<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\CustomerNotFoundException;
use App\Http\SubscriptionJson;
use App\Repository\CustomerRepository;
use App\Repository\SubscriptionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class CustomerController
{
    public function __construct(
        private readonly CustomerRepository $customers,
        private readonly SubscriptionRepository $subscriptions,
    ) {
    }

    #[Route('/customers/{id}/subscriptions', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function subscriptions(int $id): JsonResponse
    {
        $customer = $this->customers->find($id) ?? throw CustomerNotFoundException::withId($id);

        return new JsonResponse(array_map(
            SubscriptionJson::from(...),
            $this->subscriptions->findAllForCustomer($customer),
        ));
    }
}
