<?php

namespace App\Service\Event;

use App\Entity\Order;
use Symfony\Contracts\EventDispatcher\Event;

class OrderEvent extends Event
{
    public const CREATED = 'order.created';
    public const SEND = 'order.send';
    public const SENT = 'order.sent';
    public const RECEIVED = 'order.received';
    public const PROCESS = 'order.process';
    public const PROCESSED = 'order.processed';
    public const SHIPPED = 'order.shipped';
    public const DELIVERED = 'order.delivered';
    public const STATUS_CHANGED = 'order.status.changed';

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
