<?php

namespace App\Collector\OrderCalculator;

use App\Entity\Order;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class OrderCalculatorCollector
{
    #[ArrayShape([OrderedProductCalculatorInterface::class])]
    private array $orderedProductPriceCalculators = [];

    public function __construct(array $orderedProductPriceCalculators)
    {
        $this->orderedProductPriceCalculators = $orderedProductPriceCalculators;
    }

    public function calculate(Order $order): float
    {
        $price = 0;

        foreach ($order->getOrderedProducts() as $orderedProduct)
        {
            foreach ($this->orderedProductPriceCalculators as $orderedProductPriceCalculator) {
                $price = $orderedProductPriceCalculator->calculate($orderedProduct, $price);
            }
        }

        return $price;
    }
}