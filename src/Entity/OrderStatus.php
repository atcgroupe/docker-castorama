<?php

namespace App\Entity;

use App\Repository\OrderStatusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderStatusRepository::class)
 */
class OrderStatus
{
    public const CREATED = 'CREATED';
    public const SENT = 'SENT';
    public const RECEIVED = 'RECEIVED';
    public const PROCESSING = 'PROCESSING';
    public const PROCESSED = 'PROCESSED';
    public const DELIVERY = 'DELIVERY';
    public const DELIVERED = 'DELIVERED';

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     *
     * @Groups({"api"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     *
     * @Groups({"api"})
     */
    private $label;

    /**
     * @ORM\OneToOne(targetEntity=Event::class, cascade={"persist", "remove"})
     */
    private $event;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
