<?php

namespace App\Service\Member;

use App\Entity\Member;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;

class MemberSessionHandler
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @return bool
     */
    public function has(): bool
    {
        return $this->requestStack->getSession()->has(Member::SESSION_ID);
    }

    public function destroy(): void
    {
        if ($this->has()) {
            $this->requestStack->getSession()->remove(Member::SESSION_ID);
        }
    }

    /**
     * @param Member $member
     */
    public function set(Member $member): void
    {
        $this->requestStack->getSession()->set(
            Member::SESSION_ID,
            $this->serializer->serialize($member, 'json', ['groups' => 'member_session'])
        );
    }

    /**
     * @return Member | null
     */
    public function get(): Member | null
    {
        if (!$this->has()) {
            return null;
        }

        return $this->serializer->deserialize(
            $this->requestStack->getSession()->get(Member::SESSION_ID),
            Member::class,
            'json'
        );
    }
}
