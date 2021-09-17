<?php

namespace App\EventListener;

use App\Service\Event\OrderEvent;
use App\Service\Order\OrderNotificationDispatcher;

class OrderStatusListener
{
    public function __construct(
        private OrderNotificationDispatcher $orderNotificationDispatcher
    ) {
    }

    public function onOrderStatusChanged(OrderEvent $event)
    {
        $this->orderNotificationDispatcher->send($event->getOrder()->getId());
    }
}
