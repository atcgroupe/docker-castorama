<?php

namespace App\Entity;

use App\Repository\AisleOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $aisleNumber;

    /**
     * @ORM\ManyToOne(targetEntity=SignItem::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Merci de sélectionner au moins un produit.")
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=SignItem::class)
     */
    private $item2;

    /**
     * @ORM\ManyToOne(targetEntity=SignItem::class)
     */
    private $item3;

    private $category1;

    private $category2;

    private $category3;

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

    public function getItem1(): ?SignItem
    {
        return $this->item1;
    }

    public function setItem1(?SignItem $item1): self
    {
        $this->item1 = $item1;
        $this->setCategory1(($this->getItem1() !== null) ? $this->getItem1()->getCategory() : null);

        return $this;
    }

    public function getItem2(): ?SignItem
    {
        return $this->item2;
    }

    public function setItem2(?SignItem $item2): self
    {
        $this->item2 = $item2;
        $this->setCategory2(($this->getItem2() !== null) ? $this->getItem2()->getCategory() : null);

        return $this;
    }

    public function getItem3(): ?SignItem
    {
        return $this->item3;
    }

    public function setItem3(?SignItem $item3): self
    {
        $this->item3 = $item3;
        $this->setCategory3(($this->getItem3() !== null) ? $this->getItem3()->getCategory() : null);

        return $this;
    }

    /**
     * @return SignItemCategory|null
     */
    public function getCategory1(): ?SignItemCategory
    {
        return $this->category1;
    }

    /**
     * @param SignItemCategory|null $category1
     */
    public function setCategory1(?SignItemCategory $category1): void
    {
        $this->category1 = $category1;
    }

    /**
     * @return SignItemCategory|null
     */
    public function getCategory2(): ?SignItemCategory
    {
        return $this->category2;
    }

    /**
     * @param SignItemCategory|null $category2
     */
    public function setCategory2(?SignItemCategory $category2): void
    {
        $this->category2 = $category2;
    }

    /**
     * @return SignItemCategory|null
     */
    public function getCategory3(): ?SignItemCategory
    {
        return $this->category3;
    }

    /**
     * @param SignItemCategory|null $category3
     */
    public function setCategory3(?SignItemCategory $category3): void
    {
        $this->category3 = $category3;
    }
}
