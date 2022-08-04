<?php

namespace App\Service\Order;

use App\Entity\AbstractOrderSign;
use App\Entity\AbstractSign;

class VariableOrderSignCollection
{
    /**
     * @param AbstractSign $sign
     * @param AbstractOrderSign[] $items
     */
    public function __construct(
        public readonly AbstractSign $sign,
        public readonly array $items
    ) {
    }
}
