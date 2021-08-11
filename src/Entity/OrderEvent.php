<?php

namespace App\Entity;

class OrderEvent
{
    public const SENT = 'onOrderSend';
    public const RECEIVED = 'onOrderReceived';
    public const PROCESS = 'onOrderProcess';
    public const PROCESSED = 'onOrderProcessed';
    public const SHIPPED = 'onOrderShipped';
    public const DELIVERED = 'onOrderDelivered';
}
