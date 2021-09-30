<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractAisleOrderSign extends AbstractOrderSign
{
    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     * @Assert\Positive
     */
    protected $aisleNumber;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Merci de sélectionner au moins un produit.")
     */
    protected $item1;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     */
    protected $item2;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     */
    protected $item3;

    protected $category1;

    protected $category2;

    protected $category3;

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

    /**
     * @ORM\PostLoad()
     */
    public function initializeCategories()
    {
        $this->setCategory1(($this->getItem1() !== null) ? $this->getItem1()->getCategory() : null);
        $this->setCategory2(($this->getItem2() !== null) ? $this->getItem2()->getCategory() : null);
        $this->setCategory3(($this->getItem3() !== null) ? $this->getItem3()->getCategory() : null);
    }

    /**
     * @return AisleSignItemCategory|null
     */
    public function getCategory1(): ?AisleSignItemCategory
    {
        return $this->category1;
    }

    /**
     * @param AisleSignItemCategory|null $category1
     */
    public function setCategory1(?AisleSignItemCategory $category1): void
    {
        $this->category1 = $category1;
    }

    /**
     * @return AisleSignItemCategory|null
     */
    public function getCategory2(): ?AisleSignItemCategory
    {
        return $this->category2;
    }

    /**
     * @param AisleSignItemCategory|null $category2
     */
    public function setCategory2(?AisleSignItemCategory $category2): void
    {
        $this->category2 = $category2;
    }

    /**
     * @return AisleSignItemCategory|null
     */
    public function getCategory3(): ?AisleSignItemCategory
    {
        return $this->category3;
    }

    /**
     * @param AisleSignItemCategory|null $category3
     */
    public function setCategory3(?AisleSignItemCategory $category3): void
    {
        $this->category3 = $category3;
    }


    /**
     * @return string
     */
    public function getItem1Label(): string
    {
        return (null === $this->getItem1()) ? '' : $this->getItem1()->getLabel();
    }

    /**
     * @return string
     */
    public function getItem2Label(): string
    {
        return (null === $this->getItem2()) ? '' : $this->getItem2()->getLabel();
    }

    /**
     * @return string
     */
    public function getItem3Label(): string
    {
        return (null === $this->getItem3()) ? '' : $this->getItem3()->getLabel();
    }
}
