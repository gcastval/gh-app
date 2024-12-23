<?php

declare(strict_types=1);

namespace App\Controller\HealthCheck;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HealthCheckController
{
    #[Route('/health-check', name: 'health_check')]
    public function _invoke()
    {
        return new JsonResponse([
            // 'message' => 'Service is healthy',
            'code' => Response::HTTP_OK,
        ]);
    }
}
