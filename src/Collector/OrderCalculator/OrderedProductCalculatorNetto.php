<?php

namespace App\Collector\OrderCalculator;

use App\Entity\OrderedProduct;

class OrderedProductCalculatorNetto implements OrderedProductCalculatorInterface
{
    public function calculate(OrderedProduct $orderedProduct, ?float $sum): float
    {
        return $sum + $orderedProduct->getQuantity() * $orderedProduct->getProduct()->getPriceNetto();
    }
}