<?php

namespace App\EventListener;

use App\Entity\Member;
use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Service\Member\MemberSessionHandler;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class OrderRegistrationListener
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $manager,
        private MemberSessionHandler $memberSessionHandler,
    ) {
    }

    public function prePersist(Order $order, LifecycleEventArgs $args)
    {
        $order->setUser($this->security->getUser());

        $memberSession = $this->memberSessionHandler->get();
        $order->setMember(
            $this->manager->getRepository(Member::class)->find($memberSession->getId())
        );

        $order->setStatus(
            $this->manager->getRepository(OrderStatus::class)->findOneBy(['label' => OrderStatus::CREATED])
        );
    }
}
