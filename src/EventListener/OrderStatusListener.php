<?php

namespace App\EventListener;

use App\Service\Event\OrderEvent;
use App\Service\Order\OrderNotificationDispatcher;

class OrderStatusListener
{
    public function __construct(
        private readonly OrderNotificationDispatcher $orderNotificationDispatcher
    ) {
    }

    public function onOrderStatusChanged(OrderEvent $event)
    {
        if ($event->getOrder()->getStatus()->hasEvent()) {
            $this->orderNotificationDispatcher->send($event->getOrder()->getId());
        }
    }
}
