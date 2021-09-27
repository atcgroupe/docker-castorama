<?php

namespace App\Entity;

use App\Repository\AisleSmallOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AisleSmallOrderSignRepository::class)
 */
class AisleSmallOrderSign extends AbstractOrderSign
{
    private const TYPE = 'aisleSmall';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $aisleNumber;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     */
    private $item2;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     */
    private $item3;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAisleNumber(): ?int
    {
        return $this->aisleNumber;
    }

    public function setAisleNumber(int $aisleNumber): self
    {
        $this->aisleNumber = $aisleNumber;

        return $this;
    }

    public function getItem1(): ?AisleSignItem
    {
        return $this->item1;
    }

    public function setItem1(?AisleSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?AisleSignItem
    {
        return $this->item2;
    }

    public function setItem2(?AisleSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    public function getItem3(): ?AisleSignItem
    {
        return $this->item3;
    }

    public function setItem3(?AisleSignItem $item3): self
    {
        $this->item3 = $item3;

        return $this;
    }

    public static function getType(): string
    {
        return self::TYPE;
    }
}
