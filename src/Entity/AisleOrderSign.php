<?php

namespace App\Entity;

use App\Repository\AisleOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AisleOrderSignRepository::class)
 */
class AisleOrderSign extends AbstractOrderSign
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $aisleNumber;

    /**
     * @ORM\ManyToOne(targetEntity=SignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $itemOne;

    /**
     * @ORM\ManyToOne(targetEntity=SignItem::class)
     */
    private $itemTwo;

    /**
     * @ORM\ManyToOne(targetEntity=SignItem::class)
     */
    private $itemThree;

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

    public function getItemOne(): ?SignItem
    {
        return $this->itemOne;
    }

    public function setItemOne(?SignItem $itemOne): self
    {
        $this->itemOne = $itemOne;

        return $this;
    }

    public function getItemTwo(): ?SignItem
    {
        return $this->itemTwo;
    }

    public function setItemTwo(?SignItem $itemTwo): self
    {
        $this->itemTwo = $itemTwo;

        return $this;
    }

    public function getItemThree(): ?SignItem
    {
        return $this->itemThree;
    }

    public function setItemThree(?SignItem $itemThree): self
    {
        $this->itemThree = $itemThree;

        return $this;
    }
}
