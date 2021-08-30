<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    public const ORDER_CREATED = 'onOrderCreated';
    public const ORDER_SENT = 'onOrderSend';
    public const ORDER_RECEIVED = 'onOrderReceived';
    public const ORDER_PROCESS = 'onOrderProcess';
    public const ORDER_PROCESSED = 'onOrderProcessed';
    public const ORDER_SHIPPED = 'onOrderShipped';
    public const ORDER_DELIVERED = 'onOrderDelivered';

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @Groups({"member_session"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Groups({"member_session"})
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"member_session"})
     */
    private $help;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"member_session"})
     */
    private $displayOrder;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
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

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function setHelp(?string $help): self
    {
        $this->help = $help;

        return $this;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): self
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }
}
