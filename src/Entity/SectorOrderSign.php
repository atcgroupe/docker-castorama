<?php

namespace App\Entity;

use App\Repository\SectorOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectorOrderSignRepository::class)
 */
class SectorOrderSign extends AbstractOrderSign
{
    private const TYPE = 'sector';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SectorSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=SectorSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $item2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem1(): ?SectorSignItem
    {
        return $this->item1;
    }

    public function setItem1(?SectorSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?SectorSignItem
    {
        return $this->item2;
    }

    public function setItem2(?SectorSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return self::TYPE;
    }
}
