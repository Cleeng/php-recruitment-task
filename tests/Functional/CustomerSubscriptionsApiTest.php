<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CustomerSubscriptionsApiTest extends WebTestCase
{
    public function testListSubscriptions_ReturnsAllStatuses_whenCustomerExists(): void
    {
        $client = self::createClient();
        $bob = static::getContainer()->get('doctrine')
            ->getRepository(\App\Entity\Customer::class)
            ->findOneBy(['email' => 'bob@example.com']);

        $client->request('GET', '/customers/'.$bob->getId().'/subscriptions');

        self::assertResponseStatusCodeSame(200);
        $subscriptions = json_decode($client->getResponse()->getContent(), true);
        $statuses = array_column($subscriptions, 'status');
        self::assertContains('EXPIRED', $statuses);
        self::assertContains('ACTIVE', $statuses);
        self::assertSame(
            ['id', 'customerId', 'offerId', 'status', 'startedAt', 'expiresAt', 'cancelledAt'],
            array_keys($subscriptions[0]),
        );
    }

    public function testListSubscriptions_Returns404_whenCustomerUnknown(): void
    {
        $client = self::createClient();
        $client->request('GET', '/customers/999999/subscriptions');

        self::assertResponseStatusCodeSame(404);
        $body = json_decode($client->getResponse()->getContent(), true);
        self::assertSame('customer_not_found', $body['error']['code']);
    }
}
