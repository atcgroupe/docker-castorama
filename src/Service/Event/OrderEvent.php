<?php

namespace App\Service\Event;

use App\Entity\Order;
use Symfony\Contracts\EventDispatcher\Event;

class OrderEvent extends Event
{
    public const SENT = 'order.sent';

    protected Order $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }
}
