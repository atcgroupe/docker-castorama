<?php

namespace App\Service\Order;

use App\Entity\Order;

interface OrderSignHelperInterface
{
    /**
     * Returns an array of VariableOrderSigns + FixedOrderSigns
     * with sign type as key
     *
     * @param Order $order
     * @return array
     */
    public function findOrderSigns(Order $order): array;
}
