<?php

namespace App\Service\Fees;

interface FeeCalculatorInterface
{
    public function calculate(float $price, string $type): float;
}
