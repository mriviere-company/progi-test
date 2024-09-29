<?php

namespace App\Service;

class BidCalculationService
{
    private const STORAGE_FEE = 100; // Storage fee is a constant

    public function calculateTotalFees(float $price, string $type): array
    {
        // Basic buyer fee (10% with min/max caps)
        $basicFee = $this->calculateBasicFee($price, $type);

        // Seller's special fee (2% or 4% depending on type)
        $specialFee = $this->calculateSpecialFee($price, $type);

        // Association fee (based on price range)
        $associationFee = $this->calculateAssociationFee($price);

        // Fixed storage fee
        $storageFee = self::STORAGE_FEE;

        // Total fees
        $totalFees = $basicFee + $specialFee + $associationFee + $storageFee;

        // Return each fee as part of an array
        return [
            'basicFee' => round($basicFee, 2),
            'specialFee' => round($specialFee, 2),
            'associationFee' => round($associationFee, 2),
            'storageFee' => round($storageFee, 2),
            'totalFees' => round($totalFees, 2),
        ];
    }

    private function calculateBasicFee(float $price, string $type): float
    {
        $basicFeeRate = 0.10; // 10% of the base price
        $basicFee = $price * $basicFeeRate;

        if ($type === 'luxury') {
            // Min of $25 and Max of $200 for luxury
            return min(max($basicFee, 25), 200);
        }

        // Min of $10 and Max of $50 for common
        return min(max($basicFee, 10), 50);
    }

    private function calculateSpecialFee(float $price, string $type): float
    {
        if ($type === 'luxury') {
            return $price * 0.04; // 4% for luxury vehicles
        }

        return $price * 0.02; // 2% for common vehicles
    }

    private function calculateAssociationFee(float $price): float
    {
        if ($price > 3000) {
            return 20;
        } elseif ($price > 1000) {
            return 15;
        } elseif ($price > 500) {
            return 10;
        }

        return 5;
    }
}
