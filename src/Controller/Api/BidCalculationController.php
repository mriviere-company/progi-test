<?php

namespace App\Controller\Api;

use App\Service\BidCalculationService;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BidCalculationController extends AbstractController
{
    public function __construct(
        private readonly BidCalculationService $bidCalculationService
    )
    {
    }

    /**
     * @throws ReflectionException
     */
    #[Route('/api/calculate-fees', name: 'api_calculate_fees', methods: ['GET'])]
    public function calculateFees(Request $request): JsonResponse
    {
        $clientApiKey = $request->headers->get('X-API-KEY');
        $apiKey = $this->getParameter('api_key');
        if ($clientApiKey !== $apiKey) {
            return new JsonResponse(['error' => 'Invalid API key'], Response::HTTP_FORBIDDEN);
        }

        $price = $request->query->get('price');
        $type = $request->query->get('type');

        if (empty($price) || empty($type)) {
            return new JsonResponse(['error' => 'Invalid input'], 400);
        }

        $fees = $this->bidCalculationService->calculateTotalFees((float) $price, $type);

        return new JsonResponse($fees);
    }
}
