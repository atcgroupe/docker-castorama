<?php

namespace App\EventListener;

use App\Entity\Order;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class OrderStatusListener
{
    public function postUpdate(Order $order, LifecycleEventArgs $args)
    {
    }
}
