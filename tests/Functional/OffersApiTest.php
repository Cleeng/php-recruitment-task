<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class OffersApiTest extends WebTestCase
{
    public function testListOffers_ReturnsActiveOffersOnly(): void
    {
        $client = self::createClient();
        $client->request('GET', '/offers');

        self::assertResponseStatusCodeSame(200);
        $offers = json_decode($client->getResponse()->getContent(), true);
        $titles = array_column($offers, 'title');

        self::assertContains('Monthly Pass', $titles);
        self::assertContains('Annual Pass', $titles);
        self::assertNotContains('Legacy Plan', $titles);
        self::assertSame(
            ['id', 'title', 'price', 'currency', 'billingPeriod'],
            array_keys($offers[0]),
        );
        self::assertIsInt($offers[0]['price']);
    }

    public function testGetOffer_ReturnsOffer_whenItExists(): void
    {
        $client = self::createClient();
        $client->request('GET', '/offers');
        $offers = json_decode($client->getResponse()->getContent(), true);

        $client->request('GET', '/offers/'.$offers[0]['id']);

        self::assertResponseStatusCodeSame(200);
        $offer = json_decode($client->getResponse()->getContent(), true);
        self::assertSame($offers[0]['title'], $offer['title']);
    }

    public function testGetOffer_Returns404WithErrorCode_whenOfferUnknown(): void
    {
        $client = self::createClient();
        $client->request('GET', '/offers/999999');

        self::assertResponseStatusCodeSame(404);
        $body = json_decode($client->getResponse()->getContent(), true);
        self::assertSame('offer_not_found', $body['error']['code']);
        self::assertNotEmpty($body['error']['message']);
    }
}
