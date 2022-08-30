<?php

namespace App\Repository;

use App\Entity\CustomOrderSign;
use App\Entity\Order;
use App\Entity\Sign;

interface CustomOrderSignRepositoryInterface extends OrderSignRepositoryInterface
{
    /**
     * @param Order $order
     * @param Sign $sign
     * @return CustomOrderSign[]
     */
    public function findByOrderWithRelations(Order $order, Sign $sign): array;
}
