<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractOrderSign implements OrderSignInterface
{
    /**
     * @ORM\Column(type="smallint")
     */
    protected $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class)
     * @ORM\JoinColumn(nullable=false)
     */
    protected $order;

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }
}
