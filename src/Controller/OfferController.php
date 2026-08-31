<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\OfferNotFoundException;
use App\Http\OfferJson;
use App\Repository\OfferRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class OfferController
{
    public function __construct(private readonly OfferRepository $offers)
    {
    }

    #[Route('/offers', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return new JsonResponse(array_map(OfferJson::from(...), $this->offers->findAllActive()));
    }

    #[Route('/offers/{id}', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function detail(int $id): JsonResponse
    {
        $offer = $this->offers->find($id) ?? throw OfferNotFoundException::withId($id);

        return new JsonResponse(OfferJson::from($offer));
    }
}
