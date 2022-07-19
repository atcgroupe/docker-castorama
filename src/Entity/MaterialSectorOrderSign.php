<?php

namespace App\Entity;

use App\Repository\MaterialSectorOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MaterialSectorOrderSignRepository::class)
 * @UniqueEntity(
 *     fields={"order", "aisleNumber"},
 *     errorPath="aisleNumber",
 *     message="Un panneau allée avec ce numéro existe déjà dans cette commande"
 * )
 */
class MaterialSectorOrderSign extends AbstractOrderSign
{
    private const TYPE = 'materialSector';

    /**
     * @ORM\Column(type="smallint")
     */
    private $aisleNumber;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $alignment;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialSectorSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialSectorSignItem::class)
     */
    private $item2;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialSectorSignItem::class)
     */
    private $item3;

    public function getAisleNumber(): ?int
    {
        return $this->aisleNumber;
    }

    public function setAisleNumber(int $aisleNumber): self
    {
        $this->aisleNumber = $aisleNumber;

        return $this;
    }

    public function getAlignment(): ?string
    {
        return $this->alignment;
    }

    public function setAlignment(string $alignment): self
    {
        $this->alignment = $alignment;

        return $this;
    }

    public function getItem1(): ?MaterialSectorSignItem
    {
        return $this->item1;
    }

    public function setItem1(?MaterialSectorSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?MaterialSectorSignItem
    {
        return $this->item2;
    }

    public function setItem2(?MaterialSectorSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    public function getItem3(): ?MaterialSectorSignItem
    {
        return $this->item3;
    }

    public function setItem3(?MaterialSectorSignItem $item3): self
    {
        $this->item3 = $item3;

        return $this;
    }

    public static function getType(): string
    {
        return self::TYPE;
    }

    public function getFileName(): string
    {
        // TODO: Implement getFileName() method.
        return 'xxxxx';
    }
}
