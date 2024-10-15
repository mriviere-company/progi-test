<?php

namespace App\Service\Fees;

class StorageFeeCalculator implements FeeCalculatorInterface
{
    private const STORAGE_FEE = 100;

    public function calculate(float $price, string $type): float
    {
        return self::STORAGE_FEE;
    }
}
