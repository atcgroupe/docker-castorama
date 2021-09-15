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

    public function setOrderStatus(Order $order, string $orderStatus)
    {
        $order->setStatus($this->statusRepository->findOneBy(['label' => $orderStatus]));
    }
}
