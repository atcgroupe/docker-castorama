<?php

namespace App\Entity;

use App\Repository\MemberNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MemberNotificationRepository::class)
 */
class MemberNotification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $orderEvent;

    /**
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderEvent(): ?string
    {
        return $this->orderEvent;
    }

    public function setOrderEvent(string $orderEvent): self
    {
        $this->orderEvent = $orderEvent;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }
}
