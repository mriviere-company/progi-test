<?php

namespace App\Service\Fees;

class BasicFeeCalculator implements FeeCalculatorInterface
{
    public function calculate(float $price, string $type): float
    {
        $basicFeeRate = 0.10;
        $basicFee = $price * $basicFeeRate;

        if ($type === 'luxury') {
            return min(max($basicFee, 25), 200);
        }

        return min(max($basicFee, 10), 50);
    }
}
