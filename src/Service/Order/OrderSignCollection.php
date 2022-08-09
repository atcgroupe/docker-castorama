<?php

namespace App\Service\Order;

use App\Entity\AbstractOrderSign;
use App\Entity\Sign;

class OrderSignCollection
{
    /**
     * @param Sign $sign
     * @param AbstractOrderSign[] $items
     */
    public function __construct(
        public readonly Sign $sign,
        public readonly array $items
    ) {
    }
}
