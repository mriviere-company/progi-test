<?php

namespace App\Service;

use ReflectionClass;
use ReflectionException;

class BidCalculationService
{
    private iterable $calculators;

    public function __construct(iterable $calculators)
    {
        $this->calculators = $calculators;
    }

    /**
     * @throws ReflectionException
     */
    public function calculateTotalFees(float $price, string $type): array
    {
        $totalFees = 0;
        $feesDetails = [
            'basicFee' => 0,
            'specialFee' => 0,
            'associationFee' => 0,
            'storageFee' => 0,
        ];

        foreach ($this->calculators as $calculator) {
            $fee = $calculator->calculate($price, $type);
            $className = (new ReflectionClass($calculator))->getShortName();

            switch ($className) {
                case 'BasicFeeCalculator':
                    $feesDetails['basicFee'] = round($fee, 2);
                    break;
                case 'SpecialFeeCalculator':
                    $feesDetails['specialFee'] = round($fee, 2);
                    break;
                case 'AssociationFeeCalculator':
                    $feesDetails['associationFee'] = round($fee, 2);
                    break;
                case 'StorageFeeCalculator':
                    $feesDetails['storageFee'] = round($fee, 2);
                    break;
            }

            $totalFees += $fee;
        }

        $feesDetails['totalFees'] = round($totalFees, 2);

        return $feesDetails;
    }
}
