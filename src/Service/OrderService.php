<?php

namespace App\Service;

use App\Collector\OrderCalculator\OrderCalculatorCollector;
use App\Collector\OrderCalculator\OrderedProductCalculatorNetto;
use App\Collector\OrderCalculator\OrderedProductCalculatorVat;
use App\Entity\Order;

class OrderService
{
    public function setOrderPrices(Order $order) : void
    {
        $nettoOrderCalculatorCollector = new OrderCalculatorCollector([
            new OrderedProductCalculatorNetto()
        ]);
        $vatOrderCalculatorCollector = new OrderCalculatorCollector([
            new OrderedProductCalculatorVat()
        ]);
        $bruttoOrderCalculatorCollector = new OrderCalculatorCollector([
            new OrderedProductCalculatorNetto(),
            new OrderedProductCalculatorVat()
        ]);
        $order->setPriceNetto($nettoOrderCalculatorCollector->calculate($order));
        $order->setPriceVat($vatOrderCalculatorCollector->calculate($order));
        $order->setPriceBrutto($bruttoOrderCalculatorCollector->calculate($order));
    }
}