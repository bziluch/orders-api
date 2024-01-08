<?php

namespace App\Collector\OrderCalculator;

use App\Entity\OrderedProduct;

class OrderedProductCalculatorVat implements OrderedProductCalculatorInterface
{

    public function calculate(OrderedProduct $orderedProduct, float $sum): float
    {
        return $sum + (round($orderedProduct->getProduct()->getPriceNetto() * 0.23, 2) * $orderedProduct->getQuantity());
    }
}