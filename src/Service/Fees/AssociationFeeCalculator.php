<?php

namespace App\Service\Fees;

class AssociationFeeCalculator implements FeeCalculatorInterface
{
    public function calculate(float $price, string $type): float
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
