<?php

namespace App\Service\Sign;

use App\Entity\FixedSign;
use App\Repository\FixedOrderSignRepository;

class FixedSignHelper
{
    public function __construct(
        private readonly FixedOrderSignRepository $orderSignRepository,
    ) {
    }

    /**
     * @param FixedSign $sign
     * @return bool
     */
    public function isRemovable(FixedSign $sign): bool
    {
        return empty($this->orderSignRepository->findBy(['fixedSign' => $sign]));
    }
}
