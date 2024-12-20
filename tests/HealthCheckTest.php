<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HealthCheckTest extends WebTestCase
{
    public function testHealthCheck()
    {
        $client = static::createClient();
        $client->request('GET', '/health-check');
        $body = $client->getResponse()->getContent();

        $expectedBody = [
            'message' => 'Service is healthy',
            'code' => 200,
        ];

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame($body, json_encode($expectedBody));
    }
}