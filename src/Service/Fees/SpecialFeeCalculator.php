<?php

namespace App\Service\Fees;

class SpecialFeeCalculator implements FeeCalculatorInterface
{
    public function calculate(float $price, string $type): float
    {
        if ($type === 'luxury') {
            return $price * 0.04;
        }

        return $price * 0.02;
    }
}
