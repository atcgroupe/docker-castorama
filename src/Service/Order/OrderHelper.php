<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Repository\OrderStatusRepository;

class OrderHelper
{
    public function __construct(
        private readonly OrderStatusRepository $statusRepository,
    ) {
    }

    /**
     * @param Order $order
     * @param string $statusId
     * @return void
     */
    public function setOrderStatus(Order $order, string $statusId): void
    {
        $order->setStatus($this->statusRepository->find($statusId));
    }

    /**
     * @param Order $order
     * @return void
     */
    public function updateLastUpdateTime(Order $order): void
    {
        $order->setLastUpdateTime(new \DateTime('NOW'));
    }
}
