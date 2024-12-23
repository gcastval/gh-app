<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Shared\AbstractTestCase;

class HealthCheckTest extends AbstractTestCase
{
    public function testHealthCheck()
    {
        $this->client->request('GET', '/health-check');
        $body = $this->client->getResponse()->getContent();

        $expectedBody = [
            'message' => 'Service is healthy',
            'code' => 200,
        ];

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame($body, json_encode($expectedBody));
    }
}
