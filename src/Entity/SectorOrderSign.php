<?php

namespace App\Entity;

use App\Repository\SectorOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectorOrderSignRepository::class)
 */
class SectorOrderSign extends AbstractOrderSign
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $itemOne;

    /**
     * @ORM\ManyToOne(targetEntity=SignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $itemTwo;

    public function getId(): ?int
    {
        return $this->id;
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
}
