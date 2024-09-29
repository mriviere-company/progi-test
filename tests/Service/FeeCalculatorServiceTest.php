<?php

namespace App\Tests\Service;

use App\Service\BidCalculationService;
use PHPUnit\Framework\TestCase;

class FeeCalculatorServiceTest extends TestCase
{
    private BidCalculationService $bidCalculationService;

    private array $testCases = [
        [
            'price' => 398,
            'type' => 'common',
            'expectedTotal' => 550.76,
        ],
        [
            'price' => 501,
            'type' => 'common',
            'expectedTotal' => 671.02,
        ],
        [
            'price' => 57,
            'type' => 'common',
            'expectedTotal' => 173.14,
        ],
        [
            'price' => 1800,
            'type' => 'luxury',
            'expectedTotal' => 2167.00,
        ],
        [
            'price' => 1100,
            'type' => 'common',
            'expectedTotal' => 1287.00,
        ],
        [
            'price' => 1000000,
            'type' => 'luxury',
            'expectedTotal' => 1040320.00,
        ],
    ];

    protected function setUp(): void
    {
        $this->bidCalculationService = new BidCalculationService();
    }

    public function testCalculateTotalFeesForArray(): void
    {
        foreach ($this->testCases as $testCase) {
            $price = $testCase['price'];
            $type = $testCase['type'];
            $expectedTotal = $testCase['expectedTotal'];

            $totalFees = $this->bidCalculationService->calculateTotalFees($price, $type);
            $totalFeesWithPrice = $price + $totalFees;

            $this->assertEquals(
                $expectedTotal,
                $totalFeesWithPrice,
                "Failed asserting for price {$price} and type {$type}. Expected {$expectedTotal}, got {$totalFees}."
            );
        }
    }

    public function testCalculateTotalFeesForCommonVehicle(): void
    {
        $price = 1000;
        $type = 'common';

        $totalFees = $this->bidCalculationService->calculateTotalFees($price, $type);

        // Breakdown:
        // Basic fee (10% capped at $50) -> $50
        // Special fee (2% of $1000) -> $20
        // Association fee (for $1000) -> $10
        // Storage fee -> $100
        // Total should be 50 + 20 + 10 + 100 = 180
        $this->assertEquals(180, $totalFees);
    }

    public function testCalculateTotalFeesForLuxuryVehicle(): void
    {
        $price = 2000;
        $type = 'luxury';

        $totalFees = $this->bidCalculationService->calculateTotalFees($price, $type);

        // Breakdown:
        // Basic fee (10% capped at $200) -> $200
        // Special fee (4% of $2000) -> $80
        // Association fee (for $2000) -> $15
        // Storage fee -> $100
        // Total should be 200 + 80 + 15 + 100 = 395
        $this->assertEquals(395, $totalFees);
    }

    public function testCalculateAssociationFeeWithLowPrice(): void
    {
        $price = 400;
        $type = 'common';

        $totalFees = $this->bidCalculationService->calculateTotalFees($price, $type);

        // Breakdown:
        // Basic fee (10% of $400 = $40)
        // Special fee (2% of $400 = $8)
        // Association fee ($5 for <= $500)
        // Storage fee = $100
        // Total should be 40 + 8 + 5 + 100 = 153
        $this->assertEquals(153, $totalFees);
    }

    public function testCalculateBasicFeeWithEdgeCases(): void
    {
        // Test with price $1000 (common) to ensure max basic fee is applied
        $price = 1000;
        $type = 'common';
        $totalFees = $this->bidCalculationService->calculateTotalFees($price, $type);

        // Expected total: 50 (max basic) + 20 (2%) + 10 (association) + 100 (storage) = 180
        $this->assertEquals(180, $totalFees);

        // Test with price $2500 (luxury) to ensure max basic fee is applied
        $price = 2500;
        $type = 'luxury';
        $totalFees = $this->bidCalculationService->calculateTotalFees($price, $type);

        // Expected total: 200 (max basic) + 100 (4%) + 15 (association) + 100 (storage) = 415
        $this->assertEquals(415, $totalFees);
    }
}
