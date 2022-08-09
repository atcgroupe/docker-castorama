<?php

namespace App\Repository;

use App\Entity\AbstractOrderSign;
use App\Entity\Order;

interface VariableOrderSignRepositoryInterface extends OrderSignRepositoryInterface
{
    /**
     * @param Order $order
     *
     * @return AbstractOrderSign[]
     */
    public function findByOrderWithRelations(Order $order): array;
}
