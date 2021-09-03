<?php

namespace App\Entity;

use App\Repository\OrderStatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderStatusRepository::class)
 */
class OrderStatus
{
    public const CREATED = 'Création';
    public const SENT = 'Envoyée';
    public const RECEIVED = 'Reçue';
    public const PROCESSING = 'En cours de traitement';
    public const PROCESSED = 'Traitée';
    public const DELIVERY = 'Expédiée';
    public const DELIVERED = 'Livrée';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $label;

    /**
     * @ORM\OneToOne(targetEntity=Event::class, cascade={"persist", "remove"})
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
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
