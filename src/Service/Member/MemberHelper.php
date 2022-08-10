<?php

namespace App\Service\Member;

use App\Entity\Event;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;

class MemberHelper
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param Member $member
     */
    public function setDefaultMemberEvents(Member $member): void
    {
        $events = $this->entityManager->getRepository(Event::class)->findAll();

        foreach ($events as $event) {
            $member->addEvent($event);
        }
    }
}
