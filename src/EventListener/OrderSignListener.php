<?php

namespace App\EventListener;

use App\Entity\AbstractOrderSign;
use App\Repository\SignRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class OrderSignListener
{
    public function __construct(
        private SignRepository $signRepository,
    ) {
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof AbstractOrderSign) {
            return;
        }

        $entity->setSign($this->signRepository->findOneBy(['class' => get_class($entity)]));
    }
}
