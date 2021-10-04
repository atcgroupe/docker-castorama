<?php

namespace App\Service\Order;

use App\Entity\Order;
use App\Repository\OrderStatusRepository;

class OrderHelper
{
    public function __construct(
        private OrderStatusRepository $statusRepository,
    ) {
    }

    public function setOrderStatus(Order $order, string $statusId)
    {
        $order->setStatus($this->statusRepository->find($statusId));
    }

    public function updateLastUpdateTime(Order $order)
    {
        $order->setLastUpdateTime(new \DateTime('NOW'));
    }
}
