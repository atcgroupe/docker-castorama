<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractOrderSign implements OrderSignInterface
{
    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    protected $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class)
     * @ORM\JoinColumn(nullable=false)
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity=Sign::class)
     * @ORM\JoinColumn(nullable=false)
     */
    protected $sign;

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

    public function getSign(): ?Sign
    {
        return $this->sign;
    }

    public function setSign(?Sign $sign): self
    {
        $this->sign = $sign;

        return $this;
    }
}
