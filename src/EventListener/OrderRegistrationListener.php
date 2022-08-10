<?php

namespace App\EventListener;

use App\Entity\Member;
use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Service\Member\MemberSessionHandler;
use App\Service\Order\OrderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class OrderRegistrationListener
{
    public function __construct(
        private readonly Security $security,
        private readonly EntityManagerInterface $manager,
        private readonly MemberSessionHandler $memberSessionHandler,
        private readonly OrderHelper $orderHelper,
    ) {
    }

    public function prePersist(Order $order, LifecycleEventArgs $args)
    {
        if (null === $order->getUser()) {
            $order->setUser($this->security->getUser());
        }

        $memberSession = $this->memberSessionHandler->get();
        $order->setMember(
            $this->manager->getRepository(Member::class)->find($memberSession->getId())
        );

        $this->orderHelper->setOrderStatus($order, OrderStatus::CREATED);
    }
}
