<?php

namespace App\Collector\OrderCalculator;

use App\Entity\OrderedProduct;

interface OrderedProductCalculatorInterface
{
    public function calculate(
        OrderedProduct $orderedProduct,
        float $sum
    ): float;
}