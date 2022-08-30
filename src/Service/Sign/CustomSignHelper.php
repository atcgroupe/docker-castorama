<?php

namespace App\Service\Sign;

use App\Entity\Sign;
use App\Repository\CustomOrderSignRepository;

class CustomSignHelper
{
    public function __construct(
        private readonly CustomOrderSignRepository $orderSignRepository,
    ) {
    }

    /**
     * @param Sign $sign
     * @return bool
     */
    public function isRemovable(Sign $sign): bool
    {
        return empty($this->orderSignRepository->findBy(['sign' => $sign]));
    }
}
