<?php

namespace App\Entity;

use App\Repository\MaterialServiceOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MaterialServiceOrderSignRepository::class)
 * @UniqueEntity(
 *     fields={"order", "item1", "item2"},
 *     errorPath="item2",
 *     message="Un panneau identique existe déjà dans cette commande"
 * )
 */
class MaterialServiceOrderSign extends AbstractVariableOrderSign
{
    private const TYPE = 'materialService';

    /**
     * @ORM\ManyToOne(targetEntity=MaterialServiceSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=MaterialServiceSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $item2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem1(): ?MaterialServiceSignItem
    {
        return $this->item1;
    }

    public function setItem1(?MaterialServiceSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?MaterialServiceSignItem
    {
        return $this->item2;
    }

    public function setItem2(?MaterialServiceSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    public static function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     */
    public function getFileName(): string
    {
        return sprintf(
            'COMMANDE %s - COUR DES MATERIAUX - PANNEAU SERVICE ID%s %sEX.xml',
            $this->getOrderId(),
            $this->getId(),
            $this->getQuantity()
        );
    }
}
