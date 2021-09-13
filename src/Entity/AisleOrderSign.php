<?php

namespace App\Entity;

use App\Repository\AisleOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AisleOrderSignRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"order", "aisleNumber"},
 *     errorPath="aisleNumber",
 *     message="Un panneau allée avec ce numéro existe déjà dans cette commande"
 * )
 */
class AisleOrderSign extends AbstractOrderSign
{
    private const TYPE = 'aisle';

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
     * @ORM\ManyToOne(targetEntity=AisleSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Merci de sélectionner au moins un produit.")
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
     * @return string
     */
    public static function getType(): string
    {
        return self::TYPE;
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
    public function getItem1Image(): string
    {
        $image = (null === $this->getItem1()) ? 'empty' : $this->getItem1()->getImage();

        return sprintf('/build/images/sign/sign/aisle/picto/%s.svg', $image);
    }

    /**
     * @return string
     */
    public function getItem2Image(): string
    {
        $image = (null === $this->getItem2()) ? 'empty' : $this->getItem2()->getImage();

        return sprintf('/build/images/sign/sign/aisle/picto/%s.svg', $image);
    }

    /**
     * @return string
     */
    public function getItem3Image(): string
    {
        $image = (null === $this->getItem3()) ? 'empty' : $this->getItem3()->getImage();

        return sprintf('/build/images/sign/sign/aisle/picto/%s.svg', $image);
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
