<?php

namespace App\EventListener;

use App\Entity\OrderStatus;
use App\Service\Event\OrderEvent;
use App\Service\Order\OrderHelper;

class OrderSentListener
{
    public function __construct(
        private OrderHelper $orderHelper,
    ) {
    }

    public function onOrderSent(OrderEvent $event): void
    {
        $order = $event->getOrder();

        $this->orderHelper->setOrderStatus($order, OrderStatus::SENT);
        $order->setDeliveryDate($order->getCalculatedDeliveryDate());
    }
}
