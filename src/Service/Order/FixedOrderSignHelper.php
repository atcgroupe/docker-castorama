<?php

namespace App\Service\Order;

use App\Entity\FixedOrderSign;
use App\Entity\Order;
use App\Repository\FixedOrderSignRepository;

class FixedOrderSignHelper
{
    public function __construct(
        private readonly FixedOrderSignRepository $signRepository,
    ) {}

    /**
     * @param Order $order
     * @return FixedOrderSign[]
     */
    public function findAll(Order $order): array
    {
        return $this->signRepository->findByOrderWithRelations($order);
    }

    /**
     * @param Order $order
     * @return OrderSignResume[]
     */
    public function getResume(Order $order): array
    {
        $orderSigns = $this->signRepository->findByOrderWithRelations($order);
        $resumes = [];

        foreach ($orderSigns as $orderSign) {
            $resumes[] = new OrderSignResume(
                $orderSign->getFixedSign()->getCategoryLabel(),
                $orderSign->getFixedSign()->getTitle(),
                $orderSign->getFixedSign()->getCustomerReference(),
                $orderSign->getQuantity(),
                1,
                $orderSign->getFixedSign()->getPrice(),
                $orderSign->getQuantity() * $orderSign->getFixedSign()->getPrice()
            );
        }

        return $resumes;
    }

    public function removeAll(Order $order): void
    {
        $this->signRepository->removeByOrder($order);
    }
}
