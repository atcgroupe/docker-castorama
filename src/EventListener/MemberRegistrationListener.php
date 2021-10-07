<?php

namespace App\EventListener;

use App\Entity\Member;
use App\Service\Member\MemberHelper;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class MemberRegistrationListener
{
    public function __construct(
        private MemberHelper $memberHelper,
    ) {
    }

    /**
     * @param Member             $member
     * @param LifecycleEventArgs $args
     */
    public function prePersist(Member $member, LifecycleEventArgs $args): void
    {
        $this->memberHelper->setDefaultMemberEvents($member);
    }
}
